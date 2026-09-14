<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'services' => Service::active()->ordered()->get(),
            'featuredProjects' => Project::with('services')->where('is_featured', true)->ordered()->take(3)->get(),
            'featuredProducts' => Product::with('category')->active()->whereNotNull('image')->orderByDesc('is_featured')->ordered()->take(12)->get(),
            'productCategories' => ProductCategory::active()->ordered()->get(),
            'clients' => Client::where('is_featured', true)->ordered()->get(),
        ]);
    }
}
