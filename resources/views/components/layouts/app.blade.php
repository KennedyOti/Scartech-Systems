@props([
    'seoTitle' => null,
    'seoDescription' => null,
    'seoImage' => null,
    'seoType' => 'website',
    'noindex' => false,
    'canonical' => null,
])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#16294F">

    <x-seo
        :title="$seoTitle"
        :description="$seoDescription"
        :image="$seoImage"
        :type="$seoType"
        :noindex="$noindex"
        :canonical="$canonical" />

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=archivo:600,700|inter:400,500,600&display=swap">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('images/brand/apple-touch-icon.png') }}">

    {{ $head ?? '' }}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-schema.organization />
    {{ $schema ?? '' }}
</head>
<body class="bg-white font-body text-slate-700 antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-md focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-white">
        Skip to content
    </a>

    <x-site-header />

    <main id="main" tabindex="-1" class="focus:outline-none">
        {{ $slot }}
    </main>

    <x-site-footer />
    <x-whatsapp-button />
</body>
</html>
