{{-- Services without their own photograph borrow a related one from our installation library. --}}
@php
    $serviceImages = [
        'access-control-systems' => 'images/services/biometric-access-control-cabinet.jpg',
        'fiber-installation' => 'images/services/high-density-patching.jpg',
    ];
@endphp

<section id="services" class="scroll-mt-20 bg-slate-25 py-16 md:py-20" aria-labelledby="services-title">
    <div class="container-site">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between" data-reveal>
            <x-section-heading id="services-title" title="What we do" lead="Supply, installation and maintenance across ten disciplines." />
            <p class="text-meta hidden text-slate-500 md:block">Select a service for scope, standards and brands.</p>
        </div>

        <ul class="mt-10 grid gap-4 sm:grid-cols-2 md:gap-6 lg:grid-cols-5 lg:gap-5">
            @foreach ($services as $service)
                @php
                    $image = $service->hero_image ?? ($serviceImages[$service->slug] ?? null);
                    $webp = $image ? Str::replaceLast('.jpg', '.webp', $image) : null;
                @endphp

                <li data-reveal style="--reveal-delay: {{ ($loop->index % 5) * 60 }}ms">
                    <article class="group relative flex h-full flex-col rounded-lg border border-slate-200 bg-white transition-[border-color,box-shadow] duration-[120ms] hover:border-slate-300 hover:shadow-raised">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-t-lg border-b border-slate-200 bg-slate-50">
                            @if ($image)
                                <picture>
                                    @if ($webp !== $image && file_exists(public_path($webp)))
                                        <source type="image/webp" srcset="{{ asset($webp) }}">
                                    @endif
                                    <img
                                        src="{{ asset($image) }}"
                                        alt=""
                                        width="800"
                                        height="500"
                                        loading="lazy"
                                        decoding="async"
                                        class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04]"
                                    >
                                </picture>
                            @else
                                <div class="flex size-full items-center justify-center">
                                    @svg('lucide-'.$service->icon, 'size-12 text-brand-300 transition-colors duration-[120ms] group-hover:text-brand-400', ['aria-hidden' => 'true', 'stroke-width' => '1.5'])
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <span class="relative -mt-10 mb-3 flex size-10 items-center justify-center rounded-md border border-slate-200 bg-white text-brand-600 transition-colors duration-[120ms] group-hover:border-brand-600 group-hover:bg-brand-600 group-hover:text-white">
                                @svg('lucide-'.$service->icon, 'size-5', ['aria-hidden' => 'true'])
                            </span>
                            <h3 class="text-[1.0625rem] leading-snug font-semibold tracking-[-0.01em] text-slate-900">
                                <a href="{{ route('services.show', $service) }}" class="rounded-sm after:absolute after:inset-0 group-hover:text-brand-700">{{ $service->name }}</a>
                            </h3>
                            <p class="mt-1.5 text-[0.9375rem] leading-snug text-slate-500">{{ $service->tagline }}</p>
                            <span class="mt-auto inline-flex items-center gap-1 pt-4 text-sm font-semibold text-brand-600" aria-hidden="true">
                                Details
                                <x-lucide-chevron-right class="size-4 transition-transform duration-[120ms] group-hover:translate-x-0.5" />
                            </span>
                        </div>
                    </article>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('services.index') }}" class="mt-8 inline-flex min-h-11 items-center gap-2 rounded-md text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
            <span>Compare all services in detail</span>
            <x-lucide-chevron-right class="size-4" aria-hidden="true" />
        </a>
    </div>
</section>
