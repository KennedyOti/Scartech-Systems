@php
    $slides = [
        [
            'image' => 'images/hero/network-racks-patching.jpg',
            'width' => 1023, 'height' => 679,
            'alt' => 'Rows of network racks with high-density patch panels and colour-coded cabling, with an engineer walking the aisle',
            'caption' => 'Structured cabling and network racks',
            'service' => 'data-voice-solutions',
            'focus' => 'object-[60%_center]',
        ],
        [
            'image' => 'images/hero/cctv-monitoring-wall.jpg',
            'width' => 1600, 'height' => 1200,
            'alt' => 'Wall-mounted CCTV monitor showing a live split-screen view of a restaurant dining area, kitchen, stores and entrance',
            'caption' => 'Multi-camera CCTV monitoring',
            'service' => 'cctv-installation',
            'focus' => 'object-[center_30%]',
        ],
        [
            'image' => 'images/hero/boardroom-av.jpg',
            'width' => 1920, 'height' => 1280,
            'alt' => 'Boardroom with a wall-mounted display, conference camera and conference phone on the meeting table',
            'caption' => 'Boardroom audio, video and conferencing',
            'service' => 'sound-pa-solutions',
            'focus' => 'object-center',
        ],
        [
            'image' => 'images/hero/server-cabinets.jpg',
            'width' => 678, 'height' => 508,
            'alt' => 'Enclosed server and network cabinets on a raised floor in a clean server room',
            'caption' => 'Server rooms and IT infrastructure',
            'service' => 'it-solutions',
            'focus' => 'object-[70%_center]',
        ],
    ];
    $slideCount = count($slides);
    $primaryPhone = $company['offices'][0]['phones'][0];
@endphp

<section
    x-data="heroCarousel({{ $slideCount }}, 7000)"
    :class="paused && 'carousel-paused'"
    data-direction="next"
    :data-direction="direction"
    @focusin="setFocus(true)"
    @focusout="setFocus($el.contains($event.relatedTarget))"
    @touchstart.passive="touchStart($event)"
    @touchend.passive="touchEnd($event)"
    aria-labelledby="hero-title"
    class="hero relative isolate flex min-h-[640px] flex-col overflow-hidden bg-brand-900 sm:min-h-[700px] lg:min-h-[min(calc(100svh-5rem),54rem)]"
>
    {{-- Background carousel --}}
    <div
        class="absolute inset-0 -z-20"
        role="region"
        aria-roledescription="carousel"
        aria-label="Photographs of our installation work"
    >
        @foreach ($slides as $index => $slide)
            <div
                @class(['hero-slide absolute inset-0 overflow-hidden', 'is-active is-initial' => $index === 0])
                :class="{ 'is-active': current === {{ $index }}, 'is-previous': previous === {{ $index }}, 'is-initial': previous === null }"
                role="group"
                aria-roledescription="slide"
                aria-label="{{ $index + 1 }} of {{ $slideCount }}: {{ $slide['caption'] }}"
                @if ($index !== 0) aria-hidden="true" @endif
                :aria-hidden="(current !== {{ $index }}).toString()"
            >
                <picture>
                    <source type="image/webp" srcset="{{ asset(Str::replaceLast('.jpg', '.webp', $slide['image'])) }}">
                    <img
                        src="{{ asset($slide['image']) }}"
                        alt="{{ $slide['alt'] }}"
                        width="{{ $slide['width'] }}"
                        height="{{ $slide['height'] }}"
                        sizes="100vw"
                        fetchpriority="{{ $index === 0 ? 'high' : 'low' }}"
                        decoding="async"
                        class="size-full object-cover {{ $slide['focus'] }}"
                    >
                </picture>
            </div>
        @endforeach
    </div>

    {{-- Brand-blue overlay: strong behind the text for legibility, lighter on the right so the photograph shows through --}}
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute inset-0 bg-brand-900/40"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/90 via-brand-900/65 to-brand-900/10 max-lg:from-brand-900/80 max-lg:via-brand-900/70 max-lg:to-brand-900/55"></div>
        <div class="absolute inset-x-0 bottom-0 h-52 bg-gradient-to-t from-brand-900/90 to-transparent"></div>
        <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-brand-900/40 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="container-site flex flex-1 items-center pt-14 pb-12 md:pt-20 md:pb-16">
        <div class="max-w-[46rem]">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-3">
                <x-waveform variant="mark" tone="dark" :animate="true" class="h-9 w-auto" />
                <ul class="flex items-center text-[0.9375rem] font-medium text-slate-100" aria-label="What we do">
                    @foreach (['Advisory', 'Installation', 'Maintenance'] as $item)
                        <li @class(['px-3.5', 'pl-0' => $loop->first, 'border-l border-white/30' => ! $loop->first])>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <h1 id="hero-title" class="text-hero mt-7 max-w-[17ch] text-white [text-shadow:0_2px_24px_rgb(22_41_79/0.5)]">Telecom and security systems, supplied, installed and maintained.</h1>

            <p class="text-lead mt-6 max-w-[54ch] text-white [text-shadow:0_1px_12px_rgb(22_41_79/0.45)] md:text-[1.1875rem]">
                We advise, install and maintain telecommunications and electronic security systems for businesses, schools, hospitals and financial institutions across East Africa.
            </p>

            <div class="mt-9 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                <x-button :href="route('quote.create')" size="lg">Request a quote</x-button>
                <x-button href="#services" variant="dark-secondary" size="lg">See our services</x-button>
                <a href="{{ Str::telHref($primaryPhone) }}" class="group inline-flex min-h-12 items-center gap-3 rounded-md px-1 text-white sm:ml-3">
                    <span class="flex size-10 items-center justify-center rounded-full border border-white/30 transition-colors duration-[120ms] group-hover:border-white group-hover:bg-white group-hover:text-brand-900">
                        <x-lucide-phone class="size-4" aria-hidden="true" />
                    </span>
                    <span class="leading-tight">
                        <span class="block text-sm text-slate-100">Call an engineer</span>
                        <span class="block font-semibold whitespace-nowrap">{{ $primaryPhone }}</span>
                    </span>
                </a>
            </div>

            <dl class="mt-12 grid max-w-[40rem] grid-cols-2 gap-y-6 border-t border-white/20 pt-7 sm:grid-cols-4">
                @foreach ([
                    ['99.99%', 'Uptime target'],
                    ['24/7', 'Support for SLA clients'],
                    ['10', 'Service disciplines'],
                    ['3', 'Offices in East Africa'],
                ] as [$figure, $label])
                    <div @class(['flex flex-col-reverse justify-end pr-4', 'sm:border-l sm:border-white/20 sm:pl-5' => ! $loop->first])>
                        <dt class="mt-1 text-sm leading-snug text-slate-100">{{ $label }}</dt>
                        <dd class="font-display text-2xl font-semibold tracking-[-0.02em] text-white md:text-[1.75rem]">{{ $figure }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>

    {{-- Slide strip --}}
    <div class="relative border-t border-white/15">
        <div class="container-site flex items-stretch gap-4 max-md:pr-24">
            <ul class="grid flex-1 grid-cols-4 gap-2 lg:gap-6" aria-label="Choose a photograph">
                @foreach ($slides as $index => $slide)
                    <li>
                        <button
                            type="button"
                            @click="go({{ $index }})"
                            :aria-current="(current === {{ $index }}).toString()"
                            aria-label="Show photograph {{ $index + 1 }}: {{ $slide['caption'] }}"
                            class="group relative block h-full w-full pt-5 pb-5 text-left"
                        >
                            <span class="absolute inset-x-0 top-0 block h-0.5 overflow-hidden bg-white/20">
                                <template x-for="run in (current === {{ $index }} ? [cycle] : [])" :key="run">
                                    <span class="absolute inset-0 bg-white" :class="playing ? 'carousel-progress' : ''"></span>
                                </template>
                            </span>
                            <span
                                data-active="{{ $index === 0 ? 'true' : 'false' }}"
                                :data-active="(current === {{ $index }}).toString()"
                                class="hidden text-[0.9375rem] leading-snug font-medium text-slate-300 transition-colors duration-[120ms] group-hover:text-white data-[active=true]:text-white lg:block"
                            >{{ $slide['caption'] }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="flex shrink-0 items-center gap-1 py-3">
                <button type="button" @click="togglePlay()" :aria-label="playing ? 'Pause slideshow' : 'Play slideshow'" aria-label="Pause slideshow" class="inline-flex size-11 items-center justify-center rounded-md text-white hover:bg-white/10 focus-visible:outline-white">
                    <x-lucide-pause class="size-4" x-show="playing" aria-hidden="true" />
                    <x-lucide-play class="size-4" x-show="! playing" x-cloak aria-hidden="true" />
                </button>
                <button type="button" @click="prev()" aria-label="Previous photograph" class="inline-flex size-11 items-center justify-center rounded-md border border-white/25 text-white hover:border-white/60 hover:bg-white/10 focus-visible:outline-white">
                    <x-lucide-chevron-left class="size-5" aria-hidden="true" />
                </button>
                <button type="button" @click="next()" aria-label="Next photograph" class="inline-flex size-11 items-center justify-center rounded-md border border-white/25 text-white hover:border-white/60 hover:bg-white/10 focus-visible:outline-white">
                    <x-lucide-chevron-right class="size-5" aria-hidden="true" />
                </button>
            </div>
        </div>

        {{-- Current photograph caption on small screens --}}
        <div class="container-site -mt-2 pb-5 max-md:pr-24 lg:hidden">
            @foreach ($slides as $index => $slide)
                <p @if ($index !== 0) hidden @endif :hidden="current !== {{ $index }}" class="text-sm text-slate-300">
                    {{ $slide['caption'] }}
                </p>
            @endforeach
        </div>
    </div>

    <p x-ref="live" class="sr-only" aria-live="polite"></p>
</section>

<x-waveform variant="rule" class="h-9 w-full" />
