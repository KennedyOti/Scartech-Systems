@props([
    'title' => "Tell us about your site and we'll scope it.",
    'lead' => 'Share the building, the systems you need and your timeline. An engineer will come back to you within one working day.',
])

@php
    $primaryPhone = $company['offices'][0]['phones'][0];
@endphp

<section class="bg-white py-16 md:py-24" aria-labelledby="cta-title">
    <div class="container-site">
        <div class="relative overflow-hidden rounded-lg bg-brand-900 px-6 py-12 text-center sm:px-10 md:py-16">
            <x-waveform variant="rule" tone="dark" class="absolute inset-x-0 top-0 h-6 w-full opacity-60" />
            <h2 id="cta-title" class="text-section-title mx-auto max-w-[24ch] text-white">{{ $title }}</h2>
            <p class="text-lead mx-auto mt-4 max-w-[56ch] text-slate-200">{{ $lead }}</p>
            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <x-button :href="route('quote.create')" variant="dark" size="lg">Request a quote</x-button>
                <x-button :href="Str::telHref($primaryPhone)" variant="dark-secondary" size="lg" icon="phone">Call {{ $primaryPhone }}</x-button>
            </div>
        </div>
    </div>
</section>
