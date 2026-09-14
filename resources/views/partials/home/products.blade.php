@php
    $copies = $featuredProducts->isEmpty() ? 0 : max(2, (int) ceil(2600 / ($featuredProducts->count() * 280)) + 1);
@endphp

<section class="bg-slate-25 py-16 md:py-24" aria-labelledby="products-title">
    <div class="container-site">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between" data-reveal>
            <x-section-heading id="products-title" title="Products we supply" lead="Genuine equipment from our vendor partners, supplied with installation and warranty support." />
            <a href="{{ route('products.index') }}" class="inline-flex min-h-11 shrink-0 items-center gap-2 rounded-md text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
                <span>Browse all products</span>
                <x-lucide-chevron-right class="size-4" aria-hidden="true" />
            </a>
        </div>

        @if ($featuredProducts->count() >= 4)
            {{-- Continuously moving strip: pauses on hover or focus, can be dragged or swiped, and steps with the arrows --}}
            <div
                x-data="productMarquee(40)"
                class="mt-10"
                role="region"
                aria-roledescription="carousel"
                aria-label="Products we supply"
                data-reveal
            >
                <div
                    class="-mx-1 cursor-grab overflow-hidden px-1 py-1 select-none active:cursor-grabbing"
                    style="touch-action: pan-y"
                    @mouseenter="hovering = true"
                    @mouseleave="hovering = false; pointerUp()"
                    @focusin="focusWithin = true"
                    @focusout="focusWithin = $el.contains($event.relatedTarget)"
                    @pointerdown="pointerDown($event)"
                    @pointermove="pointerMove($event)"
                    @pointerup="pointerUp()"
                    @pointercancel="pointerUp()"
                    @click.capture="preventClickAfterDrag($event)"
                    @dragstart.prevent
                >
                    <div x-ref="track" class="flex w-max will-change-transform">
                        @for ($copy = 0; $copy < $copies; $copy++)
                            <ul class="flex" @if ($copy > 0) aria-hidden="true" inert @endif>
                                @foreach ($featuredProducts as $product)
                                    <li class="w-[15rem] shrink-0 pr-4 sm:w-[17.5rem] md:pr-6">
                                        <x-product-card :product="$product" class="h-full" />
                                    </li>
                                @endforeach
                            </ul>
                        @endfor
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-2">
                    <button type="button" @click="prev()" aria-label="Previous products" class="inline-flex size-11 items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 transition-colors duration-[120ms] hover:border-slate-400 hover:bg-slate-50">
                        <x-lucide-chevron-left class="size-5" aria-hidden="true" />
                    </button>
                    <button type="button" @click="next()" aria-label="Next products" class="inline-flex size-11 items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 transition-colors duration-[120ms] hover:border-slate-400 hover:bg-slate-50">
                        <x-lucide-chevron-right class="size-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        @else
            <ul class="mt-10 grid border-t border-slate-200 md:grid-cols-2 md:gap-x-10">
                @foreach ($productCategories as $category)
                    <li class="flex items-center gap-4 border-b border-slate-200 py-4">
                        @svg('lucide-'.$category->icon, 'size-5 shrink-0 text-brand-600', ['aria-hidden' => 'true'])
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="font-semibold text-slate-900 hover:text-brand-600">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
