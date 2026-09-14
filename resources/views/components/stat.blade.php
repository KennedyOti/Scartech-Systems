@props([
    'figure',
    'label',
    'tone' => 'light',
])

{{-- Only use figures the client has stated. See build plan section 10.1. --}}
<div {{ $attributes }}>
    <p @class(['font-display text-2xl font-semibold tracking-[-0.02em]', 'text-slate-900' => $tone === 'light', 'text-white' => $tone === 'dark'])>{{ $figure }}</p>
    <p @class(['text-meta mt-1', 'text-slate-500' => $tone === 'light', 'text-slate-300' => $tone === 'dark'])>{{ $label }}</p>
</div>
