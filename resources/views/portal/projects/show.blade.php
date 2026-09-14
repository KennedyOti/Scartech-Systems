<x-app-layout :title="$project->title">
    <x-portal::page-header :title="$project->title" :description="$project->summary" :back="route('portal.projects.index')" back-label="All projects">
        <x-slot:actions>
            <x-button :href="route('portfolio.show', $project)" variant="ghost" icon="external-link" target="_blank" rel="noopener">View on site</x-button>
            <x-portal::delete-button :action="route('portal.projects.destroy', $project)" :confirm="'Delete “'.$project->title.'”? Its photographs will be removed too.'" />
            <x-button :href="route('portal.projects.edit', $project)" icon="pencil">Edit</x-button>
        </x-slot:actions>
    </x-portal::page-header>

    <div class="grid gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="aspect-[16/9] w-full object-cover">
            </div>

            <x-portal::card title="Case study">
                @foreach (['The challenge' => $project->challenge, 'Our solution' => $project->solution, 'The outcome' => $project->outcome] as $heading => $text)
                    <div>
                        <h3 class="text-[0.9375rem] font-semibold text-slate-900">{{ $heading }}</h3>
                        <p class="mt-1 text-[0.9375rem] whitespace-pre-line text-slate-700">{{ $text ?: 'Not written yet.' }}</p>
                    </div>
                @endforeach
            </x-portal::card>

            <x-portal::card :title="'Site photographs ('.count($project->gallery ?? []).')'">
                @if (! empty($project->gallery))
                    <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach ($project->gallery as $path)
                            <li><img src="{{ asset($path) }}" alt="" loading="lazy" class="aspect-[4/3] w-full rounded-md border border-slate-200 object-cover"></li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-[0.9375rem] text-slate-500">No gallery photographs.</p>
                @endif
            </x-portal::card>
        </div>

        <div class="space-y-6 lg:col-span-4">
            <x-portal::card title="Details">
                <dl class="divide-y divide-slate-200 text-[0.9375rem]">
                    @foreach ([
                        'Sector' => $project->sector,
                        'Location' => $project->location,
                        'Client' => $project->client_name ?: '—',
                        'Year' => $project->year ?: '—',
                        'Display order' => $project->sort_order,
                        'URL slug' => $project->slug,
                        'Last updated' => $project->updated_at->format('j M Y, H:i'),
                    ] as $label => $value)
                        <div class="flex justify-between gap-4 py-2 first:pt-0 last:pb-0">
                            <dt class="text-slate-500">{{ $label }}</dt>
                            <dd class="text-right font-medium break-all text-slate-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
                @if ($project->is_featured)
                    <x-portal::badge tone="brand"><x-lucide-star class="size-3" aria-hidden="true" /> Featured on the home page</x-portal::badge>
                @endif
            </x-portal::card>

            <x-portal::card title="Services delivered">
                @forelse ($project->services as $service)
                    <x-portal::badge class="mr-1 mb-1">{{ $service->name }}</x-portal::badge>
                @empty
                    <p class="text-[0.9375rem] text-slate-500">No services linked.</p>
                @endforelse
            </x-portal::card>
        </div>
    </div>
</x-app-layout>
