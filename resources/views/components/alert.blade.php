@props(['type' => 'success'])

<div
    role="{{ $type === 'error' ? 'alert' : 'status' }}"
    tabindex="-1"
    x-data
    x-init="$nextTick(() => $el.focus())"
    {{ $attributes->class([
        'flex gap-3 rounded-md border px-4 py-3 text-[0.9375rem] focus:outline-none',
        'border-success/30 bg-success/5 text-success' => $type === 'success',
        'border-danger/30 bg-danger/5 text-danger' => $type === 'error',
    ]) }}
>
    @if ($type === 'error')
        <x-lucide-circle-alert class="mt-0.5 size-5 shrink-0" aria-hidden="true" />
    @else
        <x-lucide-circle-check class="mt-0.5 size-5 shrink-0" aria-hidden="true" />
    @endif
    <div class="text-slate-900">{{ $slot }}</div>
</div>
