<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\QuoteRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('portal.dashboard', [
            'stats' => [
                ['label' => 'Portfolio projects', 'figure' => Project::count(), 'route' => 'portal.projects.index'],
                ['label' => 'Products', 'figure' => Product::count(), 'route' => 'portal.products.index'],
                ['label' => 'Products live on site', 'figure' => Product::active()->count(), 'route' => 'portal.products.index'],
                ['label' => 'Quote requests, last 30 days', 'figure' => QuoteRequest::where('created_at', '>=', now()->subDays(30))->count(), 'route' => null],
            ],
            'recentProjects' => Project::latest('updated_at')->take(5)->get(),
            'recentProducts' => Product::with('category')->latest('updated_at')->take(5)->get(),
        ]);
    }
}
