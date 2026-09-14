<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', now()->addDay(), function (): string {
            $services = Service::active()->ordered()->get(['slug', 'updated_at']);
            $products = Product::active()->ordered()->get(['slug', 'updated_at']);
            $projects = Project::ordered()->get(['slug', 'updated_at']);

            $latest = collect([$services->max('updated_at'), $products->max('updated_at'), $projects->max('updated_at')])
                ->filter()
                ->max() ?? now();

            $urls = [
                ['loc' => route('home'), 'lastmod' => $latest, 'changefreq' => 'weekly', 'priority' => '1.0'],
                ['loc' => route('services.index'), 'lastmod' => $services->max('updated_at') ?? $latest, 'changefreq' => 'monthly', 'priority' => '0.9'],
                ...$services->map(fn (Service $service): array => ['loc' => route('services.show', $service), 'lastmod' => $service->updated_at, 'changefreq' => 'monthly', 'priority' => '0.8']),
                ['loc' => route('products.index'), 'lastmod' => $products->max('updated_at') ?? $latest, 'changefreq' => 'weekly', 'priority' => '0.8'],
                ...$products->map(fn (Product $product): array => ['loc' => route('products.show', $product), 'lastmod' => $product->updated_at, 'changefreq' => 'monthly', 'priority' => '0.6']),
                ['loc' => route('portfolio.index'), 'lastmod' => $projects->max('updated_at') ?? $latest, 'changefreq' => 'monthly', 'priority' => '0.8'],
                ...$projects->map(fn (Project $project): array => ['loc' => route('portfolio.show', $project), 'lastmod' => $project->updated_at, 'changefreq' => 'yearly', 'priority' => '0.6']),
                ['loc' => route('about'), 'lastmod' => $latest, 'changefreq' => 'yearly', 'priority' => '0.7'],
                ['loc' => route('contact.index'), 'lastmod' => $latest, 'changefreq' => 'yearly', 'priority' => '0.7'],
                ['loc' => route('quote.create'), 'lastmod' => $latest, 'changefreq' => 'yearly', 'priority' => '0.7'],
            ];

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml)->header('Content-Type', 'text/xml');
    }
}
