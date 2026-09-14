@props(['service'])

<article {{ $attributes->class('group relative flex flex-col border-t-2 border-slate-900/80 bg-white pt-6') }}>
    <div class="flex items-center gap-3">
        <span class="flex size-11 shrink-0 items-center justify-center rounded-md bg-brand-50 text-brand-600 transition-colors duration-[120ms] group-hover:bg-brand-100">
            @svg('lucide-'.$service->icon, 'size-5', ['aria-hidden' => 'true'])
        </span>
        <h2 class="text-card-title">{{ $service->name }}</h2>
    </div>

    <p class="mt-4 text-[0.9375rem] font-medium text-slate-600">{{ $service->tagline }}</p>

    <ul class="mt-5 flex-1 space-y-2.5 border-t border-slate-200 pt-5">
        @foreach (array_slice($service->capabilities ?? [], 0, 3) as $capability)
            <li class="flex gap-2.5 text-[0.9375rem] leading-snug text-slate-700">
                <x-lucide-check class="mt-0.5 size-4 shrink-0 text-brand-600" aria-hidden="true" />
                {{ $capability['title'] }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('services.show', $service) }}" class="mt-6 inline-flex min-h-11 items-center gap-2 self-start rounded-md text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700 after:absolute after:inset-0">
        <span>About {{ $service->name }}</span>
        <x-lucide-chevron-right class="size-4 transition-transform duration-[120ms] group-hover:translate-x-0.5" aria-hidden="true" />
    </a>
</article>
