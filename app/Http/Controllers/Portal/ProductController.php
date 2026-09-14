<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Portal\Concerns\ManagesUploads;
use App\Http\Requests\Portal\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    use ManagesUploads;

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $categories = ProductCategory::ordered()->get(['id', 'name', 'slug']);
        $activeCategory = $categories->firstWhere('slug', $request->query('category'));

        return view('portal.products.index', [
            'search' => $search,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'products' => Product::with('category')
                ->when($activeCategory, fn ($query) => $query->where('product_category_id', $activeCategory->id))
                ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%")))
                ->ordered()
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('portal.products.create', $this->formData(new Product(['is_active' => true])));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::create([
            ...$request->productAttributes(),
            'image' => $this->storeUpload($request->file('image'), 'products'),
            'gallery' => $this->storeUploads($request->file('gallery', []), 'products'),
            'datasheet_path' => $this->storeUpload($request->file('datasheet'), 'datasheets'),
        ]);

        return redirect()->route('portal.products.show', $product)->with('status', 'Product added.');
    }

    public function show(Product $product): View
    {
        return view('portal.products.show', [
            'product' => $product->load('category'),
        ]);
    }

    public function edit(Product $product): View
    {
        return view('portal.products.edit', $this->formData($product));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $attributes = $request->productAttributes();

        if ($request->hasFile('image')) {
            $this->deleteUploads($product->image);
            $attributes['image'] = $this->storeUpload($request->file('image'), 'products');
        }

        if ($request->hasFile('datasheet') || $request->validated('remove_datasheet')) {
            $this->deleteUploads($product->datasheet_path);
            $attributes['datasheet_path'] = $this->storeUpload($request->file('datasheet'), 'datasheets');
        }

        $attributes['gallery'] = $this->syncGallery(
            $product->gallery,
            $request->validated('remove_gallery'),
            $request->file('gallery', []),
            'products',
        );

        $product->update($attributes);

        return redirect()->route('portal.products.show', $product)->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteUploads([$product->image, $product->datasheet_path, ...($product->gallery ?? [])]);

        $product->delete();

        return redirect()->route('portal.products.index')->with('status', "“{$product->name}” was deleted.");
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Product $product): array
    {
        return [
            'product' => $product,
            'categories' => ProductCategory::ordered()->pluck('name', 'id')->all(),
        ];
    }
}
