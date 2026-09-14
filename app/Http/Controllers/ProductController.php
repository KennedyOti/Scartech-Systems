<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ProductCategory::active()
            ->withCount(['products' => fn ($query) => $query->active()])
            ->ordered()
            ->get();

        $activeCategory = $categories->firstWhere('slug', $request->query('category'));

        $products = Product::with('category')
            ->active()
            ->when($activeCategory, fn ($query) => $query->where('product_category_id', $activeCategory->id))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('pages.products.index', [
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'products' => $products,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        return view('pages.products.show', [
            'product' => $product,
            'relatedProducts' => Product::with('category')
                ->active()
                ->where('product_category_id', $product->product_category_id)
                ->whereKeyNot($product->getKey())
                ->ordered()
                ->take(4)
                ->get(),
        ]);
    }
}
