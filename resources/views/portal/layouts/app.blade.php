@php
    $navigation = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'layout-dashboard', 'active' => request()->routeIs('dashboard')],
        ['label' => 'Portfolio projects', 'route' => 'portal.projects.index', 'icon' => 'folder-kanban', 'active' => request()->routeIs('portal.projects.*')],
        ['label' => 'Products', 'route' => 'portal.products.index', 'icon' => 'package', 'active' => request()->routeIs('portal.products.*')],
    ];
@endphp

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
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-md focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-white">
        Skip to content
    </a>

    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="min-h-screen lg:flex">
        {{-- Mobile top bar --}}
        <div class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:hidden">
            <a href="{{ route('dashboard') }}" class="-m-1 rounded-md p-1">
                <img src="{{ asset('images/brand/scartech-logo.png') }}" alt="Scartech Systems portal" width="652" height="180" class="h-8 w-auto">
            </a>
            <button type="button" @click="sidebarOpen = true" :aria-expanded="sidebarOpen.toString()" aria-controls="portal-sidebar" class="inline-flex size-11 items-center justify-center rounded-md text-slate-700 transition-colors duration-[120ms] hover:bg-slate-50">
                <x-lucide-menu class="size-6" aria-hidden="true" />
                <span class="sr-only">Open navigation</span>
            </button>
        </div>

        {{-- Overlay for the mobile sidebar --}}
        <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/40 lg:hidden"></div>

        <aside
            id="portal-sidebar"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-200 lg:sticky lg:top-0 lg:h-screen lg:w-64 lg:translate-x-0"
        >
            <div class="flex h-20 shrink-0 items-center justify-between border-b border-slate-200 px-6">
                <a href="{{ route('dashboard') }}" class="-m-1 rounded-md p-1">
                    <img src="{{ asset('images/brand/scartech-logo.png') }}" alt="Scartech Systems portal" width="652" height="180" class="h-9 w-auto">
                </a>
                <button type="button" @click="sidebarOpen = false" class="inline-flex size-10 items-center justify-center rounded-md text-slate-500 hover:bg-slate-50 lg:hidden">
                    <x-lucide-x class="size-5" aria-hidden="true" />
                    <span class="sr-only">Close navigation</span>
                </button>
            </div>

            <nav aria-label="Portal" class="flex-1 overflow-y-auto px-3 py-6">
                <p class="px-3 text-xs font-semibold tracking-wide text-slate-400 uppercase">Manage</p>
                <ul class="mt-3 space-y-1">
                    @foreach ($navigation as $item)
                        <li>
                            <a
                                href="{{ route($item['route']) }}"
                                @if ($item['active']) aria-current="page" @endif
                                @class([
                                    'flex min-h-11 items-center gap-3 rounded-md px-3 text-[0.9375rem] font-medium transition-colors duration-[120ms]',
                                    'bg-brand-50 text-brand-700' => $item['active'],
                                    'text-slate-700 hover:bg-slate-50 hover:text-slate-900' => ! $item['active'],
                                ])
                            >
                                @svg('lucide-'.$item['icon'], ['class' => 'size-5 shrink-0', 'aria-hidden' => 'true'])
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 border-t border-slate-200 pt-6">
                    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="flex min-h-11 items-center gap-3 rounded-md px-3 text-[0.9375rem] font-medium text-slate-700 transition-colors duration-[120ms] hover:bg-slate-50 hover:text-slate-900">
                        <x-lucide-external-link class="size-5 shrink-0" aria-hidden="true" />
                        View website
                    </a>
                </div>
            </nav>

            <div class="shrink-0 border-t border-slate-200 p-3">
                <a
                    href="{{ route('profile.edit') }}"
                    @class([
                        'flex items-center gap-3 rounded-md px-3 py-2 transition-colors duration-[120ms]',
                        'bg-brand-50' => request()->routeIs('profile.*'),
                        'hover:bg-slate-50' => ! request()->routeIs('profile.*'),
                    ])
                >
                    <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-md bg-brand-900 text-sm font-semibold text-white">
                        {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                        <span class="block truncate text-xs text-slate-500">{{ Auth::user()->email }}</span>
                    </span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="flex min-h-11 w-full items-center gap-3 rounded-md px-3 text-[0.9375rem] font-medium text-slate-700 transition-colors duration-[120ms] hover:bg-slate-50 hover:text-danger">
                        <x-lucide-log-out class="size-5 shrink-0" aria-hidden="true" />
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        <main id="main" tabindex="-1" class="min-w-0 flex-1 focus:outline-none">
            <div class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-10 lg:py-10">
                @if (session('status'))
                    <x-alert class="mb-6">{{ session('status') }}</x-alert>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
