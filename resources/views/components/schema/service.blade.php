@props(['service'])

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $service->name,
    'serviceType' => $service->name,
    'description' => $service->summary,
    'url' => route('services.show', $service),
    'image' => $service->hero_image ? asset($service->hero_image) : null,
    'provider' => ['@id' => url('/').'#organization'],
    'areaServed' => collect(config('company.areas_served'))
        ->map(fn (string $country): array => ['@type' => 'Country', 'name' => $country])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
