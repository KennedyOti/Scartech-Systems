<x-layouts.app>
    <x-slot:head>
        <link rel="preload" as="image" href="{{ asset('images/hero/network-racks-patching.webp') }}" type="image/webp" fetchpriority="high">
    </x-slot:head>

    <x-slot:schema>
        <x-schema.website />
    </x-slot:schema>

    @include('partials.home.hero')

    @include('partials.home.services')

    @include('partials.home.process')

    @include('partials.home.sectors')

    @include('partials.home.projects')

    @include('partials.home.products')

    @include('partials.home.partners')

    @include('partials.home.standards')

    <x-cta-band />
</x-layouts.app>
