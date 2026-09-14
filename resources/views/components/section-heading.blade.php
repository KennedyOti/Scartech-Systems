@props([
    'title',
    'lead' => null,
    'id' => null,
    'tone' => 'light',
])

<div {{ $attributes->class('max-w-[68ch]') }}>
    <h2 @if ($id) id="{{ $id }}" @endif @class(['text-section-title', 'text-white' => $tone === 'dark'])>{{ $title }}</h2>
    @if ($lead)
        <p @class(['text-lead mt-4', 'text-slate-600' => $tone !== 'dark', 'text-slate-200' => $tone === 'dark'])>{{ $lead }}</p>
    @endif
    {{ $slot }}
</div>
