<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'services' => Service::active()->ordered()->get(),
        ]);
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        $categorySlugs = config('company.service_product_categories.'.$service->slug, []);

        return view('pages.services.show', [
            'service' => $service,
            'relatedProjects' => $service->projects()->with('services')->ordered()->take(3)->get(),
            'relatedProducts' => Product::with('category')
                ->active()
                ->whereHas('category', fn ($query) => $query->whereIn('slug', $categorySlugs))
                ->ordered()
                ->take(4)
                ->get(),
            'otherServices' => Service::active()->whereKeyNot($service->getKey())->ordered()->get(),
        ]);
    }
}
