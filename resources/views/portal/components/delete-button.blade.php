@props([
    'action',
    'confirm' => 'Delete this item? This cannot be undone.',
    'label' => 'Delete',
    'iconOnly' => false,
])

<form
    method="POST"
    action="{{ $action }}"
    x-data
    @submit="if (! confirm(@js($confirm))) $event.preventDefault()"
    {{ $attributes->class('inline') }}
>
    @csrf
    @method('DELETE')

    @if ($iconOnly)
        <button type="submit" class="inline-flex size-9 items-center justify-center rounded-md text-slate-500 transition-colors duration-[120ms] hover:bg-danger/5 hover:text-danger" title="{{ $label }}">
            <x-lucide-trash-2 class="size-[1.125rem]" aria-hidden="true" />
            <span class="sr-only">{{ $label }}</span>
        </button>
    @else
        <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-danger/30 bg-white px-5 text-[0.9375rem] font-semibold whitespace-nowrap text-danger transition-colors duration-[120ms] hover:border-danger hover:bg-danger/5">
            <x-lucide-trash-2 class="size-[1.125rem]" aria-hidden="true" />
            {{ $label }}
        </button>
    @endif
</form>
