@props([
    'project',
    'aspect' => '4/3',
    'headingLevel' => 'h3',
    'showMeta' => false,
])

<article {{ $attributes->class('group relative flex h-full flex-col rounded-lg border border-slate-200 bg-white transition-[border-color,box-shadow] duration-[120ms] hover:border-slate-300 hover:shadow-raised') }}>
    <div @class([
        'overflow-hidden rounded-t-lg border-b border-slate-200 bg-slate-50',
        'aspect-[4/3]' => $aspect === '4/3',
        'aspect-[3/2]' => $aspect === '3/2',
    ])>
        <img
            src="{{ $project->image_url }}"
            alt="{{ $project->summary }}"
            width="800"
            height="600"
            loading="lazy"
            decoding="async"
            class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
        >
    </div>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-meta text-slate-500">{{ $project->client_name ?? $project->sector }}</p>

        <{{ $headingLevel }} class="text-card-title mt-1.5">
            <a href="{{ route('portfolio.show', $project) }}" class="rounded-sm after:absolute after:inset-0 group-hover:text-brand-700">{{ $project->title }}</a>
        </{{ $headingLevel }}>

        @if ($showMeta)
            <ul class="mt-2 flex flex-wrap items-center text-sm text-slate-600" aria-label="Project details">
                @foreach (array_filter([$project->location, $project->year]) as $meta)
                    <li @class(['flex items-center gap-1.5 px-3', 'pl-0' => $loop->first, 'border-l border-slate-300' => ! $loop->first])>
                        @if ($loop->first)
                            <x-lucide-map-pin class="size-3.5 shrink-0 text-slate-400" aria-hidden="true" />
                        @endif
                        {{ $meta }}
                    </li>
                @endforeach
            </ul>
        @endif

        @if ($project->services->isNotEmpty())
            <ul class="relative z-10 mt-4 flex flex-wrap gap-2" aria-label="Services used">
                @foreach ($project->services as $projectService)
                    <li class="rounded-sm border border-slate-200 bg-slate-25 px-2 py-0.5 text-[0.8125rem] font-medium text-slate-600">{{ $projectService->name }}</li>
                @endforeach
            </ul>
        @endif

        <span class="mt-auto inline-flex items-center gap-1 pt-5 text-sm font-semibold text-brand-600" aria-hidden="true">
            View project
            <x-lucide-chevron-right class="size-4 transition-transform duration-[120ms] group-hover:translate-x-0.5" />
        </span>
    </div>
</article>
