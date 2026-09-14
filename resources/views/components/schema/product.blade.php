@props(['product'])

{{-- No "offers": there are no prices on this site. --}}
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => $product->summary,
    'image' => $product->image_url,
    'url' => route('products.show', $product),
    'sku' => $product->model_number,
    'category' => $product->category?->name,
    'brand' => $product->brand ? ['@type' => 'Brand', 'name' => $product->brand] : null,
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
