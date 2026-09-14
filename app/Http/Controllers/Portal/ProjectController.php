<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Portal\Concerns\ManagesUploads;
use App\Http\Requests\Portal\ProjectRequest;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    use ManagesUploads;

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        return view('portal.projects.index', [
            'search' => $search,
            'projects' => Project::withCount('services')
                ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('sector', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")))
                ->ordered()
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('portal.projects.create', $this->formData(new Project(['location' => 'Nairobi, Kenya'])));
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = DB::transaction(function () use ($request): Project {
            $project = Project::create([
                ...$request->projectAttributes(),
                'cover_image' => $this->storeUpload($request->file('cover_image'), 'projects'),
                'gallery' => $this->storeUploads($request->file('gallery', []), 'projects'),
            ]);

            $project->services()->sync($request->validated('services'));

            return $project;
        });

        return redirect()->route('portal.projects.show', $project)->with('status', 'Project added to the portfolio.');
    }

    public function show(Project $project): View
    {
        return view('portal.projects.show', [
            'project' => $project->load('services'),
        ]);
    }

    public function edit(Project $project): View
    {
        return view('portal.projects.edit', $this->formData($project));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $attributes = $request->projectAttributes();

        if ($request->hasFile('cover_image')) {
            $this->deleteUploads($project->cover_image);
            $attributes['cover_image'] = $this->storeUpload($request->file('cover_image'), 'projects');
        }

        $attributes['gallery'] = $this->syncGallery(
            $project->gallery,
            $request->validated('remove_gallery'),
            $request->file('gallery', []),
            'projects',
        );

        DB::transaction(function () use ($project, $attributes, $request): void {
            $project->update($attributes);
            $project->services()->sync($request->validated('services'));
        });

        return redirect()->route('portal.projects.show', $project)->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteUploads([$project->cover_image, ...($project->gallery ?? [])]);

        $project->delete();

        return redirect()->route('portal.projects.index')->with('status', "“{$project->title}” was deleted.");
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Project $project): array
    {
        return [
            'project' => $project,
            'services' => Service::ordered()->get(['id', 'name']),
            'sectors' => Project::query()->distinct()->orderBy('sector')->pluck('sector'),
        ];
    }
}
