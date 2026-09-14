@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->class('rounded-lg border border-slate-200 bg-white') }}>
    @if ($title)
        <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-5 py-4 sm:px-6">
            <div>
                <h2 class="text-base font-semibold">{{ $title }}</h2>
                @if ($description)
                    <p class="text-sm text-slate-500">{{ $description }}</p>
                @endif
            </div>
            {{ $actions ?? '' }}
        </header>
    @endif

    <div class="space-y-5 px-5 py-5 sm:px-6">
        {{ $slot }}
    </div>
</section>
