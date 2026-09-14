<x-layouts.app
    :seo-title="$activeCategory ? $activeCategory->name.' products' : 'Products we supply'"
    :seo-description="$activeCategory?->description ?? 'Genuine telephony, networking, CCTV, access control, fire, AV, POS and perimeter security equipment, supplied with installation and warranty support in Kenya.'"
    :canonical="$activeCategory || $products->currentPage() > 1 ? route('products.index', array_filter(['category' => $activeCategory?->slug, 'page' => $products->currentPage() > 1 ? $products->currentPage() : null])) : null"
>
    <x-page-header
        title="Products we supply"
        lead="Genuine equipment from our vendor partners, supplied with installation, configuration and warranty support."
        :breadcrumbs="$activeCategory
            ? [['label' => 'Products', 'url' => route('products.index')], ['label' => $activeCategory->name, 'url' => null]]
            : [['label' => 'Products', 'url' => null]]"
    />

    <section class="bg-white py-12 md:py-16" aria-label="Product catalogue">
        <div class="container-site grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-10">
            {{-- Category filter: scrollable pills on mobile, sidebar list on lg --}}
            <nav aria-label="Product categories" class="min-w-0 lg:col-span-3">
                <h2 class="text-meta hidden text-slate-500 lg:block">Categories</h2>
                <ul class="scrollbar-none -mx-5 flex gap-2 overflow-x-auto px-5 pb-1 sm:-mx-8 sm:px-8 lg:mx-0 lg:mt-3 lg:block lg:space-y-0 lg:overflow-visible lg:border-b lg:border-slate-200 lg:px-0 lg:pb-0">
                    @php
                        $filterLinks = collect([['label' => 'All products', 'slug' => null, 'count' => $categories->sum('products_count')]])
                            ->concat($categories->map(fn ($category) => ['label' => $category->name, 'slug' => $category->slug, 'count' => $category->products_count]));
                    @endphp
                    @foreach ($filterLinks as $filter)
                        @php $isCurrent = ($activeCategory?->slug) === $filter['slug']; @endphp
                        <li class="shrink-0">
                            <a
                                href="{{ route('products.index', array_filter(['category' => $filter['slug']])) }}"
                                @if ($isCurrent) aria-current="page" @endif
                                @class([
                                    'flex min-h-11 items-center justify-between gap-3 rounded-full border px-4 text-[0.9375rem] font-medium whitespace-nowrap transition-colors duration-[120ms] lg:rounded-none lg:border-x-0 lg:border-b-0 lg:border-t lg:px-0',
                                    'border-brand-600 bg-brand-600 text-white lg:border-slate-200 lg:bg-transparent lg:font-semibold lg:text-brand-600' => $isCurrent,
                                    'border-slate-200 text-slate-700 hover:border-slate-300 hover:text-slate-900 lg:hover:text-brand-600' => ! $isCurrent,
                                ])
                            >
                                {{ $filter['label'] }}
                                <span @class(['text-sm tabular-nums', 'text-white/80 lg:text-brand-600' => $isCurrent, 'text-slate-400' => ! $isCurrent])>{{ $filter['count'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="min-w-0 lg:col-span-9">
                @if ($activeCategory)
                    <div class="mb-8 max-w-[68ch]">
                        <h2 class="text-section-title">{{ $activeCategory->name }}</h2>
                        <p class="mt-3 text-slate-600">{{ $activeCategory->description }}</p>
                    </div>
                @else
                    <h2 class="sr-only">All products</h2>
                @endif

                @if ($products->isNotEmpty())
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 md:gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    {{ $products->links() }}

                    <p class="mt-10 flex flex-col gap-4 rounded-lg border border-slate-200 bg-slate-25 p-6 text-slate-700 sm:flex-row sm:items-center sm:justify-between">
                        <span>Need a model that isn't listed? We supply equipment across all eight categories on request.</span>
                        <x-button :href="route('quote.create', array_filter(['product' => $activeCategory?->name]))" variant="secondary" class="shrink-0">Ask for a quote</x-button>
                    </p>
                @else
                    <div class="rounded-lg border border-slate-200 bg-slate-25 p-8 md:p-10">
                        @svg('lucide-'.($activeCategory->icon ?? 'package'), 'size-8 text-brand-600', ['aria-hidden' => 'true'])
                        <p class="text-card-title mt-5 max-w-[40ch]">We supply equipment in this category on request. Tell us what you need and we'll quote it.</p>
                        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                            <x-button :href="route('quote.create', array_filter(['product' => $activeCategory?->name]))">Request a quote</x-button>
                            <x-button :href="route('products.index')" variant="secondary">See all products</x-button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
