@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'noindex' => false,
    'canonical' => null,
])

@php
    $siteName = config('company.short_name');
    $fullTitle = $title
        ? $title.' | '.$siteName
        : $siteName.' | IT, Telecom and Security Systems in Kenya';
    $desc = \Illuminate\Support\Str::limit(
        strip_tags($description ?? 'Scartech Systems supplies, installs and maintains CCTV, access control, VoIP, fiber, fire and PA systems for businesses across Kenya, Uganda and Rwanda.'),
        155,
        ''
    );
    $img = $image ? asset($image) : asset('images/brand/og-default.jpg');
    $canonical = $canonical ?? url()->current();
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $desc }}">
<link rel="canonical" href="{{ $canonical }}">
@if ($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow, max-image-preview:large">
@endif

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $img }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_KE">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $img }}">
