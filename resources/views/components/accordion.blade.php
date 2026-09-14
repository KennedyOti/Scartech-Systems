@props([
    'title',
    'open' => false,
])

@php
    $id = 'accordion-'.Str::random(8);
@endphp

<div x-data="{ open: {{ $open ? 'true' : 'false' }} }" {{ $attributes->class('border-b border-slate-200') }}>
    <h3>
        <button
            type="button"
            @click="open = ! open"
            :aria-expanded="open.toString()"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $id }}"
            class="flex min-h-14 w-full items-center justify-between gap-4 py-4 text-left font-display text-lg font-semibold text-slate-900 hover:text-brand-600"
        >
            {{ $title }}
            <x-lucide-chevron-down class="size-5 shrink-0 text-slate-500 transition-transform duration-200 ease-out" ::class="open && 'rotate-180'" aria-hidden="true" />
        </button>
    </h3>
    <div
        id="{{ $id }}"
        role="region"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        @unless ($open) x-cloak @endunless
        class="pb-5"
    >
        {{ $slot }}
    </div>
</div>
