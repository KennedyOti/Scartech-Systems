@php
    $meta = array_filter([
        'Client' => $project->client_name,
        'Sector' => $project->sector,
        'Location' => $project->location,
        'Year' => $project->year,
    ]);
    $narrative = array_filter([
        'The challenge' => $project->challenge,
        'Our solution' => $project->solution,
        'The outcome' => $project->outcome,
    ]);
    $gallery = collect($project->gallery ?? [])
        ->reject(fn (string $image): bool => $image === $project->cover_image)
        ->values()
        ->map(fn (string $image, int $index): array => ['src' => $image, 'alt' => $project->title.', photo '.($index + 1)]);
    $quoteParameters = $project->services->isNotEmpty() ? ['service' => $project->services->first()->slug] : [];
@endphp

<x-layouts.app
    :seo-title="$project->meta_title ?? $project->title"
    :seo-description="$project->meta_description ?? $project->summary"
    :seo-image="$project->cover_image"
    seo-type="article"
>
    <section class="border-b border-slate-200 bg-slate-25">
        <div class="container-site pt-10 pb-12 md:pt-14 md:pb-16">
            <x-breadcrumbs :items="[
                ['label' => 'Portfolio', 'url' => route('portfolio.index')],
                ['label' => $project->title, 'url' => null],
            ]" />

            <p class="text-meta mt-8 text-brand-600">{{ $project->client_name ?? $project->sector }}</p>
            <h1 class="text-page-title mt-2 max-w-[24ch]">{{ $project->title }}</h1>
            <p class="text-lead mt-5 max-w-[62ch] text-slate-600">{{ $project->summary }}</p>
        </div>
    </section>

    <x-waveform variant="rule" class="h-9 w-full" />

    <div class="container-site pt-6 md:pt-8">
        <div class="aspect-[4/3] overflow-hidden rounded-lg border border-slate-200 bg-slate-100 sm:aspect-[16/9] lg:aspect-[16/7]">
            <img src="{{ $project->image_url }}" alt="{{ $project->summary }}" width="1600" height="700" fetchpriority="high" class="size-full object-cover">
        </div>
    </div>

    <div class="container-site grid gap-10 pt-10 pb-16 md:gap-12 md:pt-16 md:pb-24 lg:grid-cols-12 lg:gap-10">
        <div class="lg:col-span-8">
            @if (count($narrative) > 0)
                <ol>
                    @foreach ($narrative as $heading => $text)
                        <li class="grid grid-cols-[3.5rem_1fr] gap-4 border-t border-slate-200 py-6 last:border-b sm:grid-cols-[5rem_1fr] md:py-8" data-reveal>
                            <span class="font-display text-3xl font-semibold tracking-[-0.02em] text-brand-600 tabular-nums sm:text-4xl" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <section aria-labelledby="narrative-{{ $loop->index }}">
                                <h2 id="narrative-{{ $loop->index }}" class="text-card-title md:text-2xl">{{ $heading }}</h2>
                                <p class="mt-3 max-w-[62ch]">{{ $text }}</p>
                            </section>
                        </li>
                    @endforeach
                </ol>
            @endif

            @if ($gallery->isNotEmpty())
                <section @class(['mt-14' => count($narrative) > 0]) aria-labelledby="gallery-title" data-reveal>
                    <h2 id="gallery-title" class="text-section-title">Site photographs</h2>
                    <p class="mt-2 text-slate-600">Select a photograph to enlarge it.</p>
                    <x-lightbox :images="$gallery->all()" columns="sm:grid-cols-2" class="mt-6" />
                </section>
            @endif
        </div>

        <aside class="order-first lg:order-last lg:col-span-4" aria-labelledby="project-details-title">
            <div class="rounded-lg border border-slate-200 bg-white lg:sticky lg:top-28">
                <h2 id="project-details-title" class="text-meta px-5 pt-5 text-slate-500">Project details</h2>
                <dl class="mt-2 px-5">
                    @foreach ($meta as $label => $value)
                        <div class="flex items-baseline justify-between gap-4 border-t border-slate-200 py-3 first:border-t-0">
                            <dt class="text-sm text-slate-500">{{ $label }}</dt>
                            <dd class="text-right font-semibold text-slate-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                @if ($project->services->isNotEmpty())
                    <div class="border-t border-slate-200 px-5 pt-5">
                        <h2 class="text-meta text-slate-500">Services used</h2>
                        <ul class="mt-2">
                            @foreach ($project->services as $projectService)
                                <li>
                                    <a href="{{ route('services.show', $projectService) }}" class="group flex min-h-12 items-center gap-3 border-t border-slate-200 py-2.5 font-semibold text-slate-900 first:border-t-0 hover:text-brand-600">
                                        <span class="flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-50 text-brand-600 transition-colors duration-[120ms] group-hover:bg-brand-600 group-hover:text-white">
                                            @svg('lucide-'.$projectService->icon, 'size-4', ['aria-hidden' => 'true'])
                                        </span>
                                        <span class="flex-1">{{ $projectService->name }}</span>
                                        <x-lucide-chevron-right class="size-4 text-slate-400 transition-[color,translate] duration-[120ms] group-hover:translate-x-0.5 group-hover:text-brand-600" aria-hidden="true" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-3 rounded-b-lg border-t border-slate-200 bg-slate-25 p-5">
                    <p class="text-[0.9375rem] leading-snug text-slate-600">Planning something similar? An engineer will scope it with you.</p>
                    <x-button :href="route('quote.create', $quoteParameters)" class="mt-4 w-full">Request a similar installation</x-button>
                </div>
            </div>
        </aside>
    </div>

    @if ($prevProject || $nextProject)
        <nav aria-labelledby="more-projects-title" class="border-t border-slate-200 bg-slate-25 py-12 md:py-16">
            <div class="container-site">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 id="more-projects-title" class="text-section-title">More projects</h2>
                    <a href="{{ route('portfolio.index') }}" class="inline-flex min-h-11 items-center gap-2 rounded-md text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
                        <span>View the portfolio</span>
                        <x-lucide-chevron-right class="size-4" aria-hidden="true" />
                    </a>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2 md:gap-6">
                    @foreach (array_filter(['prev' => $prevProject, 'next' => $nextProject]) as $direction => $siblingProject)
                        <a
                            href="{{ route('portfolio.show', $siblingProject) }}"
                            rel="{{ $direction }}"
                            @class([
                                'group flex items-center gap-4 rounded-lg border border-slate-200 bg-white p-3 transition-[border-color,box-shadow] duration-[120ms] hover:border-slate-300 hover:shadow-raised sm:p-4',
                                'sm:col-start-2 sm:flex-row-reverse sm:text-right' => $direction === 'next',
                            ])
                        >
                            <span class="block aspect-[4/3] w-24 shrink-0 overflow-hidden rounded-md bg-slate-100 sm:w-28">
                                <img src="{{ $siblingProject->image_url }}" alt="" width="224" height="168" loading="lazy" decoding="async" class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04]">
                            </span>
                            <span class="min-w-0 flex-1">
                                <span @class(['text-meta flex items-center gap-1 text-slate-500', 'sm:justify-end' => $direction === 'next'])>
                                    @if ($direction === 'prev')
                                        <x-lucide-chevron-left class="size-4" aria-hidden="true" /> Previous project
                                    @else
                                        Next project <x-lucide-chevron-right class="size-4" aria-hidden="true" />
                                    @endif
                                </span>
                                <span class="mt-1 block font-display text-lg leading-snug font-semibold text-slate-900 group-hover:text-brand-700">{{ $siblingProject->title }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
    @endif

    <x-cta-band />
</x-layouts.app>
