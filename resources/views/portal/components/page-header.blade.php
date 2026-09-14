@props([
    'title',
    'description' => null,
    'back' => null,
    'backLabel' => 'Back',
])

<div {{ $attributes->class('mb-8') }}>
    @if ($back)
        <a href="{{ $back }}" class="mb-3 inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition-colors duration-[120ms] hover:text-brand-600">
            <x-lucide-arrow-left class="size-4" aria-hidden="true" />
            {{ $backLabel }}
        </a>
    @endif

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="min-w-0">
            <h1 class="text-[clamp(1.625rem,3vw,2.125rem)] leading-tight font-bold tracking-[-0.02em]">{{ $title }}</h1>
            @if ($description)
                <p class="mt-1 text-[0.9375rem] text-slate-500">{{ $description }}</p>
            @endif
        </div>

        @isset($actions)
            <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
        @endisset
    </div>
</div>
