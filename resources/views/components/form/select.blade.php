@props([
    'name',
    'label',
    'options' => [],       // value => label, or a list of strings
    'value' => null,
    'placeholder' => 'Choose one',
    'hint' => null,
    'required' => false,
    'optional' => false,
])

@php
    $id = 'field-'.$name;
    $error = $errors->first($name);
    $selected = (string) old($name, $value);
    $describedBy = collect([$hint ? $id.'-hint' : null, $error ? $id.'-error' : null])->filter()->implode(' ');
    $normalised = array_is_list($options) ? array_combine($options, $options) : $options;
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
    <div class="relative mt-2">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            @if ($required) required @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($error) aria-invalid="true" @endif
            {{ $attributes->class([
                'block min-h-12 w-full appearance-none rounded-md border bg-white py-2.5 pr-10 pl-3.5 text-base text-slate-900 transition-colors duration-[120ms] focus:outline-2 focus:outline-offset-0 focus:outline-brand-600',
                'border-danger' => $error,
                'border-slate-300 hover:border-slate-400' => ! $error,
            ]) }}
        >
            <option value="">{{ $placeholder }}</option>
            @foreach ($normalised as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected($selected === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
        <x-lucide-chevron-down class="pointer-events-none absolute top-1/2 right-3 size-5 -translate-y-1/2 text-slate-500" aria-hidden="true" />
    </div>
    @if ($error)
        <p id="{{ $id }}-error" class="mt-1.5 text-sm font-medium text-danger">{{ $error }}</p>
    @endif
</div>
