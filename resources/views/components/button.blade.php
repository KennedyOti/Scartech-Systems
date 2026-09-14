@props([
    'href' => null,
    'variant' => 'primary', // primary | secondary | ghost | dark | dark-secondary
    'size' => 'md',         // md | lg
    'icon' => null,
    'type' => 'button',
])

@php
    $classes = [
        'inline-flex items-center justify-center gap-2 rounded-md font-semibold whitespace-nowrap transition-colors duration-[120ms] focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-60',
        $size === 'lg' ? 'min-h-12 px-6 text-base' : 'min-h-11 px-5 text-[0.9375rem]',
        match ($variant) {
            'secondary' => 'border border-slate-300 bg-white text-slate-900 hover:border-slate-400 hover:bg-slate-50 focus-visible:outline-brand-600',
            'ghost' => 'px-3 text-brand-600 hover:bg-brand-50 hover:text-brand-700 focus-visible:outline-brand-600',
            'dark' => 'bg-white text-brand-900 hover:bg-brand-50 focus-visible:outline-white',
            'dark-secondary' => 'border border-white/30 text-white hover:border-white/60 hover:bg-white/5 focus-visible:outline-white',
            default => 'bg-brand-600 text-white hover:bg-brand-700 focus-visible:outline-brand-600',
        },
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        @if ($icon)
            @svg('lucide-'.$icon, 'size-[1.125rem] shrink-0', ['aria-hidden' => 'true'])
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        @if ($icon)
            @svg('lucide-'.$icon, 'size-[1.125rem] shrink-0', ['aria-hidden' => 'true'])
        @endif
        {{ $slot }}
    </button>
@endif
