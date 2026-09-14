@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'hint' => null,
    'required' => false,
    'optional' => false,
    'bag' => 'default',
    'id' => null,
])

@php
    $id ??= 'field-'.$name;
    $error = $errors->getBag($bag)->first($name);
    $describedBy = collect([$hint ? $id.'-hint' : null, $error ? $id.'-error' : null])->filter()->implode(' ');
@endphp

<div>
    <label for="{{ $id }}" class="block text-[0.9375rem] font-medium text-slate-900">
        {{ $label }}
        @if ($optional)
            <span class="font-normal text-slate-500">(optional)</span>
        @endif
    </label>
    @if ($hint)
        <p id="{{ $id }}-hint" class="mt-1 text-sm text-slate-500">{{ $hint }}</p>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if ($required) required @endif
        @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
        @if ($error) aria-invalid="true" @endif
        {{ $attributes->class([
            'mt-2 block min-h-12 w-full rounded-md border bg-white px-3.5 py-2.5 text-base text-slate-900 placeholder:text-slate-400 transition-colors duration-[120ms] focus:outline-2 focus:outline-offset-0 focus:outline-brand-600',
            'border-danger' => $error,
            'border-slate-300 hover:border-slate-400' => ! $error,
        ]) }}
    >
    @if ($error)
        <p id="{{ $id }}-error" class="mt-1.5 text-sm font-medium text-danger">{{ $error }}</p>
    @endif
</div>
