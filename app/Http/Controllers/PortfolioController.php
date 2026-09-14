<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::active()->whereHas('projects')->ordered()->get(['id', 'name', 'slug']);
        $sectors = Project::query()->distinct()->orderBy('sector')->pluck('sector');

        $activeService = $services->firstWhere('slug', $request->query('service'));
        $activeSector = $sectors->contains($request->query('sector')) ? $request->query('sector') : null;

        $projects = Project::with('services')
            ->when($activeService, fn ($query) => $query->whereHas('services', fn ($services) => $services->whereKey($activeService->id)))
            ->when($activeSector, fn ($query) => $query->where('sector', $activeSector))
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        return view('pages.portfolio.index', [
            'projects' => $projects,
            'services' => $services,
            'sectors' => $sectors,
            'activeService' => $activeService,
            'activeSector' => $activeSector,
            'projectCount' => Project::count(),
            'clients' => Client::ordered()->get(),
        ]);
    }

    public function show(Project $project): View
    {
        $project->load('services');

        $ordered = Project::ordered()->get(['id', 'title', 'slug', 'sector', 'cover_image', 'sort_order']);
        $position = $ordered->search(fn (Project $item): bool => $item->is($project));

        return view('pages.portfolio.show', [
            'project' => $project,
            'prevProject' => $position > 0 ? $ordered->get($position - 1) : null,
            'nextProject' => $ordered->get($position + 1),
        ]);
    }
}
