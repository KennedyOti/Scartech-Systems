@props([
    'images' => [],   // list of ['src' => string, 'alt' => string]
    'columns' => 'sm:grid-cols-2 lg:grid-cols-3',
])

@php
    $lightboxImages = collect($images)->map(fn (array $image): array => [
        'src' => asset($image['src']),
        'alt' => $image['alt'],
    ])->values();
@endphp

<div x-data="lightbox(@js($lightboxImages))" {{ $attributes }}>
    <ul class="grid grid-cols-1 gap-4 {{ $columns }}">
        @foreach ($lightboxImages as $index => $image)
            <li @class(['sm:col-span-2 sm:row-span-2' => $loop->first && $lightboxImages->count() > 2])>
                <button
                    type="button"
                    @click="show({{ $index }})"
                    class="group block size-full overflow-hidden rounded-lg bg-slate-100"
                    aria-label="Enlarge image: {{ $image['alt'] }}"
                >
                    <img
                        src="{{ $image['src'] }}"
                        alt="{{ $image['alt'] }}"
                        width="800"
                        height="600"
                        loading="lazy"
                        decoding="async"
                        class="aspect-[4/3] size-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                    >
                </button>
            </li>
        @endforeach
    </ul>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            x-ref="dialog"
            x-transition.opacity.duration.150ms
            @keydown.escape.window="open && close()"
            @keydown.arrow-right.window="open && next()"
            @keydown.arrow-left.window="open && prev()"
            role="dialog"
            aria-modal="true"
            aria-label="Image viewer"
            class="fixed inset-0 z-[70] flex flex-col bg-slate-900/95"
        >
            <div class="flex items-center justify-between px-4 py-3 text-sm text-slate-200">
                <p aria-live="polite"><span x-text="index + 1"></span> of <span x-text="images.length"></span></p>
                <button type="button" x-ref="close" @click="close()" aria-label="Close image viewer" class="inline-flex size-11 items-center justify-center rounded-md text-white hover:bg-white/10 focus-visible:outline-white">
                    <x-lucide-x class="size-6" aria-hidden="true" />
                </button>
            </div>

            <div class="relative flex min-h-0 flex-1 items-center justify-center px-4 pb-4 md:px-20" @click.self="close()">
                <img :src="images[index]?.src" :alt="images[index]?.alt" class="max-h-full max-w-full rounded-lg object-contain">

                <template x-if="images.length > 1">
                    <div>
                        <button type="button" @click="prev()" aria-label="Previous image" class="absolute top-1/2 left-2 inline-flex size-12 -translate-y-1/2 items-center justify-center rounded-md bg-white/10 text-white hover:bg-white/20 focus-visible:outline-white md:left-4">
                            <x-lucide-chevron-left class="size-6" aria-hidden="true" />
                        </button>
                        <button type="button" @click="next()" aria-label="Next image" class="absolute top-1/2 right-2 inline-flex size-12 -translate-y-1/2 items-center justify-center rounded-md bg-white/10 text-white hover:bg-white/20 focus-visible:outline-white md:right-4">
                            <x-lucide-chevron-right class="size-6" aria-hidden="true" />
                        </button>
                    </div>
                </template>
            </div>

            <p class="px-4 pb-5 text-center text-sm text-slate-300" x-text="images[index]?.alt"></p>
        </div>
    </template>
</div>
