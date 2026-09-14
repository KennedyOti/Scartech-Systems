<?php

use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->admin = User::factory()->admin()->create();
});

/**
 * @return array<string, mixed>
 */
function projectPayload(array $overrides = []): array
{
    return [
        'title' => 'Hospital CCTV upgrade',
        'slug' => '',
        'sector' => 'Healthcare',
        'location' => 'Nairobi, Kenya',
        'year' => 2025,
        'summary' => 'Replaced analogue cameras with IP cameras across four wards.',
        'challenge' => 'Blind spots in the corridors.',
        'is_featured' => '1',
        'sort_order' => 3,
        ...$overrides,
    ];
}

it('redirects guests from the portal to the login page', function (string $url) {
    $this->get($url)->assertRedirect(route('login'));
})->with(['/portal', '/portal/projects', '/portal/products', '/portal/projects/create']);

it('shows the dashboard with project and product counts', function () {
    Project::factory()->count(2)->create();

    $this->actingAs($this->admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Portfolio projects')
        ->assertSee('Recently updated projects');
});

it('lists and searches projects', function () {
    Project::factory()->create(['title' => 'Bank vault access control']);
    Project::factory()->create(['title' => 'School PA system']);

    $this->actingAs($this->admin)
        ->get(route('portal.projects.index', ['search' => 'vault']))
        ->assertOk()
        ->assertSee('Bank vault access control')
        ->assertDontSee('School PA system');
});

it('renders the project create, show and edit screens', function () {
    $project = Project::factory()->create();

    $this->actingAs($this->admin)->get(route('portal.projects.create'))->assertOk()->assertSee('Add project');
    $this->actingAs($this->admin)->get(route('portal.projects.show', $project))->assertOk()->assertSee($project->title);
    $this->actingAs($this->admin)->get(route('portal.projects.edit', $project))->assertOk()->assertSee('Save changes');
});

it('creates a project with uploaded photographs and services', function () {
    $service = Service::factory()->create();

    $response = $this->actingAs($this->admin)->post(route('portal.projects.store'), projectPayload([
        'cover_image' => UploadedFile::fake()->image('cover.jpg', 1200, 800),
        'gallery' => [UploadedFile::fake()->image('one.jpg'), UploadedFile::fake()->image('two.png')],
        'services' => [$service->id],
    ]));

    $project = Project::firstWhere('slug', 'hospital-cctv-upgrade');

    $response->assertRedirect(route('portal.projects.show', $project));

    expect($project->is_featured)->toBeTrue()
        ->and($project->cover_image)->toStartWith('storage/projects/')
        ->and($project->gallery)->toHaveCount(2)
        ->and($project->services->modelKeys())->toBe([$service->id]);

    Storage::disk('public')->assertExists(str_replace('storage/', '', $project->cover_image));

    $this->get(route('portfolio.show', $project))->assertOk()->assertSee('Hospital CCTV upgrade');
});

it('requires a cover image and a unique slug when creating a project', function () {
    Project::factory()->create(['slug' => 'hospital-cctv-upgrade']);

    $this->actingAs($this->admin)
        ->post(route('portal.projects.store'), projectPayload())
        ->assertSessionHasErrors(['cover_image', 'slug']);
});

it('replaces the cover and removes ticked gallery photographs on update', function () {
    $oldCover = UploadedFile::fake()->image('old.jpg')->store('projects', 'public');
    $oldGallery = UploadedFile::fake()->image('gallery.jpg')->store('projects', 'public');

    $project = Project::factory()->create([
        'cover_image' => 'storage/'.$oldCover,
        'gallery' => ['storage/'.$oldGallery, 'images/projects/bundled.jpg'],
    ]);

    $this->actingAs($this->admin)->put(route('portal.projects.update', $project), projectPayload([
        'title' => $project->title,
        'slug' => $project->slug,
        'cover_image' => UploadedFile::fake()->image('new.jpg'),
        'remove_gallery' => ['storage/'.$oldGallery],
        'gallery' => [UploadedFile::fake()->image('extra.jpg')],
    ]))->assertRedirect(route('portal.projects.show', $project))->assertSessionHasNoErrors();

    $project->refresh();

    Storage::disk('public')->assertMissing($oldCover);
    Storage::disk('public')->assertMissing($oldGallery);

    expect($project->cover_image)->not->toBe('storage/'.$oldCover)
        ->and($project->gallery)->toHaveCount(2)
        ->and($project->gallery[0])->toBe('images/projects/bundled.jpg');
});

it('keeps the existing cover when none is uploaded on update', function () {
    $project = Project::factory()->create(['cover_image' => 'images/projects/bundled.jpg']);

    $this->actingAs($this->admin)
        ->put(route('portal.projects.update', $project), projectPayload(['title' => 'Renamed project']))
        ->assertSessionHasNoErrors();

    expect($project->refresh())
        ->title->toBe('Renamed project')
        ->cover_image->toBe('images/projects/bundled.jpg');
});

it('deletes a project and its uploaded photographs', function () {
    $cover = UploadedFile::fake()->image('cover.jpg')->store('projects', 'public');
    $project = Project::factory()->create(['cover_image' => 'storage/'.$cover]);

    $this->actingAs($this->admin)
        ->delete(route('portal.projects.destroy', $project))
        ->assertRedirect(route('portal.projects.index'));

    expect(Project::find($project->id))->toBeNull();
    Storage::disk('public')->assertMissing($cover);
});
