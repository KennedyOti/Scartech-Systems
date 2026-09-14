@php
    $primaryPhone = $company['offices'][0]['phones'][0];
    $galleryImages = collect($product->gallery_images)
        ->map(fn (string $src, int $index): array => ['src' => $src, 'alt' => $index === 0 ? $product->name : $product->name.', view '.($index + 1)]);
@endphp

<x-layouts.app
    :seo-title="$product->meta_title ?? $product->name"
    :seo-description="$product->meta_description ?? $product->summary"
    :seo-image="$product->image"
    seo-type="product"
>
    <x-slot:schema>
        <x-schema.product :product="$product" />
    </x-slot:schema>

    <div class="container-site pt-10 pb-16 md:pt-14 md:pb-24">
        <x-breadcrumbs :items="[
            ['label' => 'Products', 'url' => route('products.index')],
            ['label' => $product->category->name, 'url' => route('products.index', ['category' => $product->category->slug])],
            ['label' => $product->name, 'url' => null],
        ]" />

        <div class="mt-8 grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-12">
            <div class="min-w-0 lg:col-span-7" x-data="{ active: 0 }">
                <div x-data="lightbox(@js($galleryImages->map(fn ($image) => ['src' => asset($image['src']), 'alt' => $image['alt']])))">
                    <button type="button" @click="show(active)" class="group block w-full overflow-hidden rounded-lg border border-slate-200 bg-white" aria-label="Enlarge image of {{ $product->name }}">
                        @foreach ($galleryImages as $index => $image)
                            <img
                                src="{{ asset($image['src']) }}"
                                alt="{{ $image['alt'] }}"
                                width="1200"
                                height="1200"
                                @if ($index === 0) fetchpriority="high" @else loading="lazy" hidden @endif
                                :hidden="active !== {{ $index }}"
                                class="aspect-square w-full object-contain p-8 md:p-14"
                            >
                        @endforeach
                    </button>

                    @if ($galleryImages->count() > 1)
                        <ul class="scrollbar-none mt-4 flex snap-x gap-3 overflow-x-auto" aria-label="Product images">
                            @foreach ($galleryImages as $index => $image)
                                <li class="snap-start">
                                    <button type="button" @click="active = {{ $index }}" :aria-pressed="(active === {{ $index }}).toString()" aria-label="Show image {{ $index + 1 }}" class="block size-20 overflow-hidden rounded-md border-2 bg-white p-1" :class="active === {{ $index }} ? 'border-brand-600' : 'border-slate-200'">
                                        <img src="{{ asset($image['src']) }}" alt="" width="80" height="80" loading="lazy" class="size-full object-contain">
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <template x-teleport="body">
                        <div x-show="open" x-cloak x-ref="dialog" x-transition.opacity.duration.150ms @keydown.escape.window="open && close()" @keydown.arrow-right.window="open && next()" @keydown.arrow-left.window="open && prev()" role="dialog" aria-modal="true" aria-label="Image viewer" class="fixed inset-0 z-[70] flex flex-col bg-slate-900/95">
                            <div class="flex justify-end px-4 py-3">
                                <button type="button" x-ref="close" @click="close()" aria-label="Close image viewer" class="inline-flex size-11 items-center justify-center rounded-md text-white hover:bg-white/10 focus-visible:outline-white">
                                    <x-lucide-x class="size-6" aria-hidden="true" />
                                </button>
                            </div>
                            <div class="flex min-h-0 flex-1 items-center justify-center p-4" @click.self="close()">
                                <img :src="images[index]?.src" :alt="images[index]?.alt" class="max-h-full max-w-full rounded-lg bg-white object-contain p-6">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="lg:col-span-5">
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-meta rounded-sm text-brand-600 hover:text-brand-700">{{ $product->category->name }}</a>
                <h1 class="text-page-title mt-3">{{ $product->name }}</h1>

                @if ($product->brand || $product->model_number)
                    <dl class="mt-5 flex flex-wrap text-[0.9375rem]">
                        @if ($product->brand)
                            <div class="pr-5">
                                <dt class="text-sm text-slate-500">Brand</dt>
                                <dd class="font-semibold text-slate-900">{{ $product->brand }}</dd>
                            </div>
                        @endif
                        @if ($product->model_number)
                            <div @class(['pr-5', 'border-l border-slate-200 pl-5' => $product->brand])>
                                <dt class="text-sm text-slate-500">Model</dt>
                                <dd class="font-mono font-semibold text-slate-900">{{ $product->model_number }}</dd>
                            </div>
                        @endif
                    </dl>
                @endif

                <p class="text-lead mt-6 text-slate-600">{{ $product->summary }}</p>

                @if (! empty($product->features))
                    <h2 class="mt-8 text-lg font-semibold">Key features</h2>
                    <ul class="mt-3 space-y-2.5">
                        @foreach ($product->features as $feature)
                            <li class="flex gap-2.5">
                                <x-lucide-check class="mt-1 size-4 shrink-0 text-brand-600" aria-hidden="true" />
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-8 flex flex-col gap-3 border-t border-slate-200 pt-8 sm:flex-row">
                    <x-button :href="route('quote.create', ['product' => $product->name])" size="lg">Request a quote</x-button>
                    <x-button :href="Str::telHref($primaryPhone)" variant="secondary" size="lg" icon="phone">Call us</x-button>
                </div>
                <p class="mt-4 text-sm text-slate-500">Supplied with installation, configuration and manufacturer warranty.</p>
            </div>
        </div>

        @if ($product->description || ! empty($product->specifications))
            <div class="mt-16 grid grid-cols-1 gap-12 border-t border-slate-200 pt-12 lg:grid-cols-12 lg:gap-12">
                @if ($product->description)
                    <section class="lg:col-span-6" aria-labelledby="overview-title">
                        <h2 id="overview-title" class="text-section-title">Overview</h2>
                        <div class="rich-text mt-5">{!! $product->description !!}</div>
                    </section>
                @endif

                @if (! empty($product->specifications))
                    <section @class(['lg:col-span-6', 'lg:col-start-7' => ! $product->description]) aria-labelledby="specs-title">
                        <h2 id="specs-title" class="text-section-title">Specifications</h2>
                        <table class="mt-5 w-full border-collapse text-left text-[0.9375rem]">
                            <caption class="sr-only">{{ $product->name }} specifications</caption>
                            <tbody>
                                @foreach ($product->specifications as $specification)
                                    <tr class="border-t border-slate-200 last:border-b">
                                        <th scope="row" class="w-2/5 py-3.5 pr-4 align-top font-medium text-slate-500">{{ $specification['label'] }}</th>
                                        <td class="py-3.5 text-slate-900">{{ $specification['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                @endif
            </div>
        @endif

        @if ($relatedProducts->isNotEmpty())
            <section class="mt-20" aria-labelledby="related-title">
                <h2 id="related-title" class="text-section-title">More in {{ $product->category->name }}</h2>
                <div class="mt-8 grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <x-cta-band />
</x-layouts.app>
