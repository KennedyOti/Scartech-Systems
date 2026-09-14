@props([
    'product',
    'headingLevel' => 'h3',
])

<article {{ $attributes->class('group relative flex flex-col rounded-lg border border-slate-200 bg-white transition-colors duration-[120ms] hover:border-slate-300') }}>
    <div class="aspect-square overflow-hidden rounded-t-lg border-b border-slate-200 bg-white p-4 sm:p-6">
        <img
            src="{{ $product->image_url }}"
            alt="{{ $product->name }}"
            width="600"
            height="600"
            loading="lazy"
            decoding="async"
            class="size-full object-contain transition-transform duration-300 group-hover:scale-[1.03]"
        >
    </div>
    <div class="flex flex-1 flex-col p-3.5 sm:p-5">
        @if ($product->relationLoaded('category') && $product->category)
            <p class="text-meta text-slate-500">{{ $product->category->name }}</p>
        @endif
        <{{ $headingLevel }} class="mt-1 text-base leading-snug font-semibold text-slate-900">
            <a href="{{ route('products.show', $product) }}" class="rounded-sm after:absolute after:inset-0 group-hover:text-brand-700">{{ $product->name }}</a>
        </{{ $headingLevel }}>
        @if ($product->brand)
            <p class="mt-2 text-sm text-slate-500">{{ $product->brand }}@if ($product->model_number) <span class="font-mono text-[0.8125rem]">{{ $product->model_number }}</span>@endif</p>
        @endif
    </div>
</article>
