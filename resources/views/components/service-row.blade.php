@props(['service'])

<a
    href="{{ route('services.show', $service) }}"
    {{ $attributes->class('group flex items-center gap-4 border-t border-slate-200 px-2 py-4 transition-colors duration-[120ms] hover:bg-white focus-visible:bg-white focus-visible:-outline-offset-2 sm:px-3 md:py-5') }}
>
    <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-brand-50 text-brand-600 transition-colors duration-[120ms] group-hover:bg-brand-100">
        @svg('lucide-'.$service->icon, 'size-5', ['aria-hidden' => 'true'])
    </span>
    <div class="min-w-0 flex-1">
        <h3 class="text-[1.0625rem] leading-snug font-semibold tracking-[-0.01em] text-slate-900 group-hover:text-brand-700">{{ $service->name }}</h3>
        <p class="mt-0.5 text-[0.9375rem] leading-snug text-slate-500">{{ $service->tagline }}</p>
    </div>
    <x-lucide-chevron-right class="size-5 shrink-0 text-slate-400 transition-transform duration-[120ms] group-hover:translate-x-0.5 group-hover:text-brand-600" aria-hidden="true" />
</a>
