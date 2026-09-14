@props([
    'name',
    'label',
    'checked' => false,
    'hint' => null,
])

@php
    $id = 'field-'.$name;
    $error = $errors->first($name);
    $isChecked = (bool) old($name, $checked);
@endphp

<div>
    <div class="flex items-start gap-3">
        <input type="hidden" name="{{ $name }}" value="0">
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="1"
            @checked($isChecked)
            @if ($hint || $error) aria-describedby="{{ $hint ? $id.'-hint' : '' }} {{ $error ? $id.'-error' : '' }}" @endif
            @if ($error) aria-invalid="true" @endif
            {{ $attributes->class('mt-0.5 size-5 shrink-0 rounded-sm border-slate-300 accent-brand-600') }}
        >
        <div>
            <label for="{{ $id }}" class="text-[0.9375rem] font-medium text-slate-900">{{ $label }}</label>
            @if ($hint)
                <p id="{{ $id }}-hint" class="text-sm text-slate-500">{{ $hint }}</p>
            @endif
        </div>
    </div>
    @if ($error)
        <p id="{{ $id }}-error" class="mt-1.5 text-sm font-medium text-danger">{{ $error }}</p>
    @endif
</div>
