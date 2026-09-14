<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ $title ? $title.' · ' : '' }}Scartech Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=archivo:600,700|inter:400,500,600&display=swap">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-25 font-body text-slate-700 antialiased">
    <main class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <a href="{{ route('home') }}" class="-m-1 rounded-md p-1">
            <img src="{{ asset('images/brand/scartech-logo.png') }}" alt="Scartech Systems" width="652" height="180" class="h-12 w-auto">
        </a>

        <div class="mt-8 w-full max-w-md rounded-lg border border-slate-200 bg-white p-6 sm:p-8">
            {{ $slot }}
        </div>

        <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition-colors duration-[120ms] hover:text-brand-600">
            <x-lucide-arrow-left class="size-4" aria-hidden="true" />
            Back to the website
        </a>
    </main>
</body>
</html>
