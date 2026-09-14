<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->admin = User::factory()->admin()->create();
    $this->category = ProductCategory::factory()->create();
});

it('lists products filtered by category, including hidden ones', function () {
    $other = ProductCategory::factory()->create();
    Product::factory()->for($this->category, 'category')->create(['name' => 'Hidden dome camera']);
    Product::factory()->active()->for($other, 'category')->create(['name' => 'Fire alarm panel']);

    $this->actingAs($this->admin)
        ->get(route('portal.products.index', ['category' => $this->category->slug]))
        ->assertOk()
        ->assertSee('Hidden dome camera')
        ->assertDontSee('Fire alarm panel');
});

it('renders the product create, show and edit screens', function () {
    $product = Product::factory()->for($this->category, 'category')->create();

    $this->actingAs($this->admin)->get(route('portal.products.create'))->assertOk()->assertSee('Add product');
    $this->actingAs($this->admin)->get(route('portal.products.show', $product))->assertOk()->assertSee($product->name);
    $this->actingAs($this->admin)->get(route('portal.products.edit', $product))->assertOk()->assertSee('Save changes');
});

it('creates a product, parsing features and specifications and storing uploads', function () {
    $this->actingAs($this->admin)->post(route('portal.products.store'), [
        'product_category_id' => $this->category->id,
        'name' => 'Hikvision 4 MP dome camera',
        'brand' => 'Hikvision',
        'summary' => 'An indoor dome camera.',
        'features_text' => "Night vision\n\nWide dynamic range\n",
        'specifications_text' => "Resolution: 4 MP\nLens: 2.8 mm",
        'image' => UploadedFile::fake()->image('camera.png'),
        'datasheet' => UploadedFile::fake()->create('datasheet.pdf', 200, 'application/pdf'),
        'is_active' => '1',
    ])->assertSessionHasNoErrors();

    $product = Product::firstWhere('slug', 'hikvision-4-mp-dome-camera');

    expect($product)
        ->is_active->toBeTrue()
        ->features->toBe(['Night vision', 'Wide dynamic range'])
        ->specifications->toBe([['label' => 'Resolution', 'value' => '4 MP'], ['label' => 'Lens', 'value' => '2.8 mm']])
        ->image->toStartWith('storage/products/')
        ->datasheet_path->toStartWith('storage/datasheets/');

    $this->get(route('products.show', $product))->assertOk()->assertSee('Hikvision 4 MP dome camera');
});

it('rejects a specification line without a value', function () {
    $this->actingAs($this->admin)->post(route('portal.products.store'), [
        'product_category_id' => $this->category->id,
        'name' => 'Access control reader',
        'summary' => 'A card reader.',
        'specifications_text' => 'Just a label',
    ])->assertSessionHasErrors('specifications.0.value');

    expect(Product::count())->toBe(0);
});

it('hides a product and removes its datasheet on update', function () {
    $datasheet = UploadedFile::fake()->create('old.pdf', 100, 'application/pdf')->store('datasheets', 'public');
    $product = Product::factory()->active()->for($this->category, 'category')->create(['datasheet_path' => 'storage/'.$datasheet]);

    $this->actingAs($this->admin)->put(route('portal.products.update', $product), [
        'product_category_id' => $this->category->id,
        'name' => $product->name,
        'slug' => $product->slug,
        'summary' => $product->summary,
        'is_active' => '0',
        'remove_datasheet' => '1',
    ])->assertRedirect(route('portal.products.show', $product));

    Storage::disk('public')->assertMissing($datasheet);

    expect($product->refresh())
        ->is_active->toBeFalse()
        ->datasheet_path->toBeNull();

    $this->get(route('products.show', $product))->assertNotFound();
});

it('deletes a product and its uploaded image', function () {
    $image = UploadedFile::fake()->image('camera.jpg')->store('products', 'public');
    $product = Product::factory()->for($this->category, 'category')->create(['image' => 'storage/'.$image]);

    $this->actingAs($this->admin)
        ->delete(route('portal.products.destroy', $product))
        ->assertRedirect(route('portal.products.index'));

    expect(Product::find($product->id))->toBeNull();
    Storage::disk('public')->assertMissing($image);
});
