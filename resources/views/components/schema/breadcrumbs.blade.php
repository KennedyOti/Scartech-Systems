@props(['items' => []])

{{-- $items: list of ['label' => string, 'url' => string|null]. The last item is the current page. --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($items)->values()->map(fn (array $item, int $index): array => [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item['label'],
        'item' => $item['url'] ?? url()->current(),
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
