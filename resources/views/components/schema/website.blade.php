<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    '@id' => url('/').'#website',
    'name' => config('company.short_name'),
    'url' => url('/'),
    'publisher' => ['@id' => url('/').'#organization'],
    'inLanguage' => 'en',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
