@php
    $filterClasses = fn (bool $isCurrent): string => $isCurrent
        ? 'border-brand-600 bg-brand-600 text-white'
        : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900';
    $filterBase = 'inline-flex min-h-10 items-center rounded-md border px-3.5 text-[0.9375rem] font-medium whitespace-nowrap transition-colors duration-[120ms]';
    $isFiltered = $activeService || $activeSector;
    $stats = array_filter([
        [$projectCount, Str::plural('Documented project', $projectCount)],
        [$services->count(), Str::plural('Service discipline', $services->count())],
        [$sectors->count(), Str::plural('Sector', $sectors->count())],
        [$clients->count(), Str::plural('Client organisation', $clients->count())],
    ], fn (array $stat): bool => $stat[0] > 0);
@endphp

<x-layouts.app
    seo-title="Our work"
    seo-description="Executed installations by Scartech Systems: structured cabling and network racks, CCTV monitoring and server cabinets, and biometric access control in Kenya."
    :canonical="$isFiltered || $projects->currentPage() > 1 ? request()->fullUrl() : null"
>
    <x-page-header
        title="Our work"
        lead="Executed installations — structured cabling, surveillance control rooms, and biometric access."
        :breadcrumbs="[['label' => 'Portfolio', 'url' => null]]"
    >
        @if (count($stats) > 1)
            <dl class="mt-10 grid max-w-[48rem] grid-cols-2 gap-y-6 border-t border-slate-200 pt-7 sm:grid-cols-4">
                @foreach ($stats as [$figure, $label])
                    <div @class(['flex flex-col-reverse justify-end pr-4', 'sm:border-l sm:border-slate-200 sm:pl-5' => ! $loop->first])>
                        <dt class="mt-1 text-sm leading-snug text-slate-500">{{ $label }}</dt>
                        <dd class="font-display text-2xl font-semibold tracking-[-0.02em] text-slate-900 tabular-nums md:text-[1.75rem]">{{ $figure }}</dd>
                    </div>
                @endforeach
            </dl>
        @endif
    </x-page-header>

    <x-waveform variant="rule" class="h-9 w-full" />

    <section class="bg-white pt-8 pb-16 md:pt-10 md:pb-24" aria-label="Projects">
        <div class="container-site">
            <div class="space-y-4 rounded-lg border border-slate-200 bg-slate-25 p-4 sm:p-5">
                <nav aria-label="Filter projects by service" class="flex flex-col gap-2 sm:flex-row sm:items-start sm:gap-4">
                    <h2 class="text-meta w-20 shrink-0 text-slate-500 sm:pt-2.5">Service</h2>
                    <ul class="scrollbar-none -mx-4 flex gap-2 overflow-x-auto px-4 [mask-image:linear-gradient(to_right,#000_85%,transparent)] sm:mx-0 sm:flex-wrap sm:overflow-visible sm:px-0 sm:[mask-image:none]">
                        <li class="shrink-0">
                            <a href="{{ route('portfolio.index', array_filter(['sector' => $activeSector])) }}" @if (! $activeService) aria-current="true" @endif class="{{ $filterBase }} {{ $filterClasses(! $activeService) }}">All services</a>
                        </li>
                        @foreach ($services as $filterService)
                            <li class="shrink-0">
                                <a href="{{ route('portfolio.index', array_filter(['service' => $filterService->slug, 'sector' => $activeSector])) }}" @if ($activeService?->is($filterService)) aria-current="true" @endif class="{{ $filterBase }} {{ $filterClasses((bool) $activeService?->is($filterService)) }}">{{ $filterService->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                @if ($sectors->count() > 1)
                    <nav aria-label="Filter projects by sector" class="flex flex-col gap-2 border-t border-slate-200 pt-4 sm:flex-row sm:items-start sm:gap-4">
                        <h2 class="text-meta w-20 shrink-0 text-slate-500 sm:pt-2.5">Sector</h2>
                        <ul class="scrollbar-none -mx-4 flex gap-2 overflow-x-auto px-4 [mask-image:linear-gradient(to_right,#000_85%,transparent)] sm:mx-0 sm:flex-wrap sm:overflow-visible sm:px-0 sm:[mask-image:none]">
                            <li class="shrink-0">
                                <a href="{{ route('portfolio.index', array_filter(['service' => $activeService?->slug])) }}" @if (! $activeSector) aria-current="true" @endif class="{{ $filterBase }} {{ $filterClasses(! $activeSector) }}">All sectors</a>
                            </li>
                            @foreach ($sectors as $sector)
                                <li class="shrink-0">
                                    <a href="{{ route('portfolio.index', array_filter(['service' => $activeService?->slug, 'sector' => $sector])) }}" @if ($activeSector === $sector) aria-current="true" @endif class="{{ $filterBase }} {{ $filterClasses($activeSector === $sector) }}">{{ $sector }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif
            </div>

            <div class="mt-8 flex min-h-11 flex-wrap items-center justify-between gap-x-6 gap-y-2">
                <p class="text-meta text-slate-600" aria-live="polite">
                    {{ $projects->total() }} {{ Str::plural('project', $projects->total()) }}
                    @if ($activeService)
                        in <span class="text-slate-900">{{ $activeService->name }}</span>
                    @endif
                    @if ($activeSector)
                        for <span class="text-slate-900">{{ $activeSector }}</span>
                    @endif
                </p>
                @if ($isFiltered)
                    <a href="{{ route('portfolio.index') }}" class="inline-flex min-h-11 items-center gap-1.5 rounded-md text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
                        <x-lucide-x class="size-4" aria-hidden="true" />
                        Clear filters
                    </a>
                @endif
            </div>

            @if ($projects->isNotEmpty())
                <ul class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <li data-reveal style="--reveal-delay: {{ ($loop->index % 3) * 60 }}ms">
                            <x-project-card :project="$project" aspect="3/2" heading-level="h3" :show-meta="true" />
                        </li>
                    @endforeach
                </ul>

                {{ $projects->links() }}
            @else
                <div class="mt-6 rounded-lg border border-slate-200 bg-slate-25 p-8">
                    <p class="text-card-title">No projects match those filters yet.</p>
                    <p class="mt-2 text-slate-600">We may still have done this kind of work. Ask us for references.</p>
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <x-button :href="route('portfolio.index')" variant="secondary">Clear filters</x-button>
                        <x-button :href="route('contact.index')" variant="ghost">Contact us</x-button>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if ($clients->isNotEmpty())
        <section class="border-y border-slate-200 bg-slate-25 py-16 md:py-24" aria-labelledby="portfolio-clients-title">
            <div class="container-site" data-reveal>
                <x-section-heading
                    id="portfolio-clients-title"
                    title="Organisations we have worked with"
                    lead="From hospitals and banks to government agencies, embassies and hotels across Kenya and Rwanda — on direct contracts and as a sub-contractor to IT firms."
                />
                <x-client-wall :clients="$clients" class="mt-10" />
            </div>
        </section>
    @endif

    <x-cta-band />
</x-layouts.app>
