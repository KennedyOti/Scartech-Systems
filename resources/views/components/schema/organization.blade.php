@props(['services' => null])

@php
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => ['Organization', 'LocalBusiness'],
        '@id' => url('/').'#organization',
        'name' => config('company.legal_name'),
        'alternateName' => config('company.short_name'),
        'url' => url('/'),
        'logo' => asset('images/brand/scartech-logo.png'),
        'image' => asset('images/brand/og-default.jpg'),
        'email' => config('company.email'),
        'telephone' => config('company.offices.0.phones.0'),
        'description' => 'Supply, installation and maintenance of IT, telecommunications and electronic security systems across East Africa.',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Nairobi',
            'addressCountry' => 'KE',
        ],
        'areaServed' => collect(config('company.areas_served'))
            ->map(fn (string $country): array => ['@type' => 'Country', 'name' => $country])->all(),
        'sameAs' => array_values(array_filter(config('company.socials'))),
    ];

    if (request()->routeIs('home')) {
        $catalogServices = once(fn () => \App\Models\Service::active()->ordered()->get(['name', 'slug', 'summary']));

        $organization['hasOfferCatalog'] = [
            '@type' => 'OfferCatalog',
            'name' => 'Services',
            'itemListElement' => $catalogServices->map(fn ($service): array => [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => $service->name,
                    'url' => route('services.show', $service),
                ],
            ])->all(),
        ];
    }
@endphp

<script type="application/ld+json">
{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
