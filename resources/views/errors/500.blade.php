{{-- Standalone: must render even if the database or asset build is unavailable. --}}
@php
    $companyConfig = config('company');
    $phone = $companyConfig['offices'][0]['phones'][0];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Something went wrong | {{ $companyConfig['short_name'] }}</title>
    <style>
        body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, sans-serif; color: #363F4E; background: #FFFFFF; }
        main { max-width: 36rem; margin: 0 auto; padding: 5rem 1.25rem; }
        img { height: 44px; width: auto; }
        h1 { font-family: Archivo, ui-sans-serif, system-ui, sans-serif; color: #141A23; font-size: clamp(2rem, 4vw, 3rem); line-height: 1.1; letter-spacing: -0.02em; margin: 2.5rem 0 1rem; }
        p { font-size: 1.125rem; line-height: 1.65; }
        a { color: #3560BC; font-weight: 600; }
    </style>
</head>
<body>
    <main>
        <img src="{{ asset('images/brand/scartech-logo.png') }}" alt="Scartech Systems" width="652" height="180">
        <h1>Something went wrong on our end.</h1>
        <p>We have been notified. Please try again in a few minutes. If you need us now, call <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a> or email <a href="mailto:{{ $companyConfig['email'] }}">{{ $companyConfig['email'] }}</a>.</p>
        <p><a href="{{ url('/') }}">Return to the home page</a></p>
    </main>
</body>
</html>
