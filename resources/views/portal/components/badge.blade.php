@props(['tone' => 'neutral']) {{-- neutral | brand | success --}}

<span {{ $attributes->class([
    'inline-flex items-center gap-1 rounded-sm border px-1.5 py-0.5 text-xs font-medium whitespace-nowrap',
    'border-slate-200 bg-slate-50 text-slate-600' => $tone === 'neutral',
    'border-brand-200 bg-brand-50 text-brand-700' => $tone === 'brand',
    'border-success/30 bg-success/5 text-success' => $tone === 'success',
]) }}>{{ $slot }}</span>
