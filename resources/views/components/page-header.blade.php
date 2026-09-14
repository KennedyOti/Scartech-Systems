@props([
    'title',
    'lead' => null,
    'breadcrumbs' => [],
])

<section {{ $attributes->class('border-b border-slate-200 bg-slate-25') }}>
    <div class="container-site pt-10 pb-12 md:pt-14 md:pb-16">
        <x-breadcrumbs :items="$breadcrumbs" />
        <h1 class="text-page-title mt-6 max-w-[22ch]">{{ $title }}</h1>
        @if ($lead)
            <p class="text-lead mt-5 max-w-[62ch] text-slate-600">{{ $lead }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
