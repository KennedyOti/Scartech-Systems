@php
    $primaryPhone = $company['offices'][0]['phones'][0];

    $links = [
        ['label' => 'Home', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'About', 'route' => 'about', 'active' => request()->routeIs('about')],
        ['label' => 'Services', 'route' => 'services.index', 'active' => request()->routeIs('services.*'), 'mega' => true],
        ['label' => 'Products', 'route' => 'products.index', 'active' => request()->routeIs('products.*')],
        ['label' => 'Portfolio', 'route' => 'portfolio.index', 'active' => request()->routeIs('portfolio.*')],
        ['label' => 'Contact', 'route' => 'contact.index', 'active' => request()->routeIs('contact.*')],
    ];
@endphp

<header
    x-data="siteHeader"
    @keydown.escape.window="mobileOpen ? closeMobile() : closeServices(true)"
    :data-scrolled="scrolled"
    class="group/header sticky top-0 z-40 border-b border-slate-200 bg-white transition-shadow duration-150 data-[scrolled=true]:shadow-raised"
>
    <div class="container-site flex h-16 items-center justify-between gap-6 transition-[height] duration-200 group-data-[scrolled=true]/header:h-14 md:h-20 md:group-data-[scrolled=true]/header:h-16">
        <a href="{{ route('home') }}" aria-label="Scartech Systems — home" class="-m-1 shrink-0 rounded-md p-1">
            <img
                src="{{ asset('images/brand/scartech-logo.png') }}"
                alt=""
                width="652"
                height="180"
                class="h-9 w-auto md:h-11"
            >
        </a>

        <nav aria-label="Primary" class="hidden h-full lg:block">
            <ul class="flex h-full items-center gap-1">
                @foreach ($links as $link)
                    <li class="flex h-full items-center">
                        @if ($link['mega'] ?? false)
                            <button
                                type="button"
                                x-ref="servicesTrigger"
                                @click="toggleServices()"
                                :aria-expanded="servicesOpen.toString()"
                                aria-expanded="false"
                                aria-controls="services-panel"
                                @class([
                                    'relative flex h-full items-center gap-1 px-3 text-[0.9375rem] font-medium transition-colors duration-100 hover:text-brand-600',
                                    'text-slate-900 after:absolute after:inset-x-3 after:bottom-0 after:h-0.5 after:bg-brand-600' => $link['active'],
                                    'text-slate-700' => ! $link['active'],
                                ])
                            >
                                {{ $link['label'] }}
                                <x-lucide-chevron-down class="size-4 transition-transform duration-200" ::class="servicesOpen && 'rotate-180'" aria-hidden="true" />
                            </button>
                        @else
                            <a
                                href="{{ route($link['route']) }}"
                                @if ($link['active']) aria-current="page" @endif
                                @class([
                                    'relative flex h-full items-center px-3 text-[0.9375rem] font-medium transition-colors duration-100 hover:text-brand-600',
                                    'text-slate-900 after:absolute after:inset-x-3 after:bottom-0 after:h-0.5 after:bg-brand-600' => $link['active'],
                                    'text-slate-700' => ! $link['active'],
                                ])
                            >{{ $link['label'] }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex items-center gap-2 sm:gap-4">
            <a href="{{ Str::telHref($primaryPhone) }}" class="hidden items-center gap-2 rounded-md text-[0.9375rem] font-medium whitespace-nowrap text-slate-900 transition-colors duration-100 hover:text-brand-600 md:flex">
                <x-lucide-phone class="size-4 text-brand-600" aria-hidden="true" />
                {{ $primaryPhone }}
            </a>

            <x-button :href="route('quote.create')" class="max-sm:hidden">Request a quote</x-button>

            <button
                type="button"
                x-ref="mobileTrigger"
                @click="openMobile()"
                :aria-expanded="mobileOpen.toString()"
                aria-expanded="false"
                aria-controls="mobile-nav"
                aria-label="Open menu"
                class="-mr-2 inline-flex size-11 items-center justify-center rounded-md text-slate-900 hover:bg-slate-50 lg:hidden"
            >
                <x-lucide-menu class="size-6" aria-hidden="true" />
            </button>
        </div>
    </div>

    {{-- Services mega-panel (lg+) --}}
    <div
        id="services-panel"
        x-cloak
        x-show="servicesOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.outside="if (! $refs.servicesTrigger.contains($event.target)) closeServices()"
        class="absolute inset-x-0 top-full hidden border-b border-slate-200 bg-white lg:block"
    >
        <div class="container-site grid grid-cols-12 gap-10 py-8">
            <div class="col-span-3 border-r border-slate-200 pr-8">
                <p class="text-card-title text-slate-900">Ten disciplines, one team</p>
                <p class="mt-3 text-sm text-slate-600">Every service we list, we survey, supply, install and maintain ourselves.</p>
                <a href="{{ route('services.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-md text-sm font-semibold text-brand-600 hover:text-brand-700">
                    <span>View all services</span>
                    <x-lucide-chevron-right class="size-4" aria-hidden="true" />
                </a>
            </div>
            <ul class="col-span-9 grid grid-flow-col grid-cols-2 grid-rows-5 gap-x-8">
                @foreach ($navServices as $navService)
                    <li>
                        <a
                            href="{{ route('services.show', $navService) }}"
                            @if (request()->is('services/'.$navService->slug)) aria-current="page" @endif
                            class="group flex items-start gap-3 rounded-md px-3 py-2.5 transition-colors duration-100 hover:bg-slate-50"
                        >
                            <span class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-md bg-brand-50 text-brand-600 group-hover:bg-brand-100">
                                @svg('lucide-'.$navService->icon, 'size-4', ['aria-hidden' => 'true'])
                            </span>
                            <span>
                                <span class="block text-[0.9375rem] leading-snug font-semibold text-slate-900">{{ $navService->name }}</span>
                                <span class="block text-sm leading-snug text-slate-500">{{ $navService->tagline }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Mobile sheet --}}
    <div x-cloak x-show="mobileOpen" class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
        <div
            x-show="mobileOpen"
            x-transition:enter="transition-opacity duration-250"
            x-transition:enter-start="opacity-0"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-end="opacity-0"
            @click="closeMobile()"
            class="absolute inset-0 bg-slate-900/40"
        ></div>

        <div
            id="mobile-nav"
            x-ref="mobileSheet"
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="shadow-raised absolute inset-y-0 right-0 flex w-full max-w-sm flex-col bg-white"
        >
            <div class="flex h-16 items-center justify-between border-b border-slate-200 px-5">
                <img src="{{ asset('images/brand/scartech-logo.png') }}" alt="Scartech Systems" width="652" height="180" class="h-8 w-auto">
                <button type="button" @click="closeMobile()" aria-label="Close menu" class="-mr-2 inline-flex size-11 items-center justify-center rounded-md text-slate-900 hover:bg-slate-50">
                    <x-lucide-x class="size-6" aria-hidden="true" />
                </button>
            </div>

            <nav aria-label="Mobile" class="flex-1 overflow-y-auto px-5 py-4" x-data="{ servicesExpanded: {{ request()->routeIs('services.*') ? 'true' : 'false' }} }">
                <ul class="divide-y divide-slate-200">
                    @foreach ($links as $link)
                        <li>
                            @if ($link['mega'] ?? false)
                                <button
                                    type="button"
                                    @click="servicesExpanded = ! servicesExpanded"
                                    :aria-expanded="servicesExpanded.toString()"
                                    aria-controls="mobile-services"
                                    class="flex min-h-12 w-full items-center justify-between py-3 text-left text-base font-semibold text-slate-900"
                                >
                                    {{ $link['label'] }}
                                    <x-lucide-chevron-down class="size-5 text-slate-500 transition-transform duration-200" ::class="servicesExpanded && 'rotate-180'" aria-hidden="true" />
                                </button>
                                <ul id="mobile-services" x-show="servicesExpanded" x-transition.opacity.duration.200ms class="pb-3" @unless (request()->routeIs('services.*')) x-cloak @endunless>
                                    @foreach ($navServices as $navService)
                                        <li>
                                            <a href="{{ route('services.show', $navService) }}" class="flex min-h-11 items-center gap-3 rounded-md px-2 py-2 text-[0.9375rem] text-slate-700 hover:bg-slate-50">
                                                @svg('lucide-'.$navService->icon, 'size-4 shrink-0 text-brand-600', ['aria-hidden' => 'true'])
                                                {{ $navService->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="{{ route('services.index') }}" class="flex min-h-11 items-center px-2 text-[0.9375rem] font-semibold text-brand-600">All services</a>
                                    </li>
                                </ul>
                            @else
                                <a
                                    href="{{ route($link['route']) }}"
                                    @if ($link['active']) aria-current="page" @endif
                                    @class([
                                        'flex min-h-12 items-center py-3 text-base font-semibold',
                                        'text-brand-600' => $link['active'],
                                        'text-slate-900' => ! $link['active'],
                                    ])
                                >{{ $link['label'] }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="space-y-3 border-t border-slate-200 p-5">
                <x-button :href="route('quote.create')" class="w-full">Request a quote</x-button>
                <x-button :href="Str::telHref($primaryPhone)" variant="secondary" icon="phone" class="w-full">{{ $primaryPhone }}</x-button>
            </div>
        </div>
    </div>
</header>
