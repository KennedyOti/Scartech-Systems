@props(['items' => []])

{{-- $items: list of ['label' => string, 'url' => string|null]; the last item is the current page. --}}
@php
    $trail = [['label' => 'Home', 'url' => route('home')], ...$items];
@endphp

<nav aria-label="Breadcrumb" {{ $attributes }}>
    <ol class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-sm text-slate-500">
        @foreach ($trail as $crumb)
            <li class="flex items-center gap-1.5">
                @if (! $loop->first)
                    <x-lucide-chevron-right class="size-3.5 shrink-0 text-slate-400" aria-hidden="true" />
                @endif
                @if ($loop->last)
                    <span aria-current="page" class="text-slate-700">{{ $crumb['label'] }}</span>
                @else
                    <a href="{{ $crumb['url'] }}" class="rounded-sm underline-offset-4 hover:text-brand-600 hover:underline">{{ $crumb['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

<x-schema.breadcrumbs :items="$trail" />
