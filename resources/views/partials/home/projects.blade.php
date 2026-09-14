@if ($featuredProjects->isNotEmpty())
    @php
        $hasLeadProject = $featuredProjects->count() === 3;
    @endphp

    <section class="bg-white py-16 md:py-24" aria-labelledby="projects-title">
        <div class="container-site">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between" data-reveal>
                <x-section-heading id="projects-title" title="Selected projects" lead="Installations from our own engineering teams." />
                <a href="{{ route('portfolio.index') }}" class="inline-flex min-h-11 shrink-0 items-center gap-2 rounded-md text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
                    <span>View the portfolio</span>
                    <x-lucide-chevron-right class="size-4" aria-hidden="true" />
                </a>
            </div>

            <div @class(['mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3', 'lg:grid-rows-2' => $hasLeadProject])>
                @foreach ($featuredProjects as $project)
                    @php
                        $isLead = $hasLeadProject && $loop->first;
                    @endphp

                    <div @class(['md:col-span-2 lg:row-span-2' => $isLead]) data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                        <article @class([
                            'group relative isolate flex h-full flex-col justify-end overflow-hidden rounded-lg bg-slate-900',
                            'min-h-[22rem] md:min-h-[26rem] lg:min-h-[32rem]' => $isLead,
                            'min-h-[18rem]' => ! $isLead,
                            'lg:min-h-0' => $hasLeadProject && ! $isLead,
                        ])>
                            <img
                                src="{{ $project->image_url }}"
                                alt="{{ $project->summary }}"
                                width="1000"
                                height="750"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 -z-10 size-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                            >
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-slate-900/95 via-slate-900/65 to-slate-900/10"></div>

                            <div @class(['p-5 md:p-6', 'lg:p-8' => $isLead])>
                                <p class="text-meta text-slate-200">{{ $project->client_name ?? $project->sector }}</p>

                                <h3 @class(['mt-1.5 text-white', 'text-section-title' => $isLead, 'text-card-title' => ! $isLead])>
                                    <a href="{{ route('portfolio.show', $project) }}" class="rounded-sm after:absolute after:inset-0 focus-visible:outline-white">{{ $project->title }}</a>
                                </h3>

                                @if ($project->services->isNotEmpty())
                                    <ul class="relative z-10 mt-4 flex flex-wrap gap-2" aria-label="Services used">
                                        @foreach ($project->services as $projectService)
                                            <li class="rounded-sm bg-white px-2 py-0.5 text-[0.8125rem] font-medium text-slate-700">{{ $projectService->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-white" aria-hidden="true">
                                    View project
                                    <x-lucide-chevron-right class="size-4 transition-transform duration-[120ms] group-hover:translate-x-0.5" />
                                </span>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
