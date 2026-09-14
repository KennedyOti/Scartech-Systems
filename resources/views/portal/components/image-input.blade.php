@props([
    'name',
    'label',
    'current' => null, // URL of the image already saved
    'hint' => 'JPG, PNG or WebP, up to 5 MB.',
    'required' => false,
])

@php
    $id = 'field-'.$name;
    $error = $errors->first($name);
@endphp

<div x-data="{ preview: @js($current), fileName: '' }">
    <label for="{{ $id }}" class="block text-[0.9375rem] font-medium text-slate-900">{{ $label }}</label>
    <p id="{{ $id }}-hint" class="mt-1 text-sm text-slate-500">{{ $hint }}</p>

    <div @class([
        'mt-2 overflow-hidden rounded-md border bg-slate-50',
        'border-danger' => $error,
        'border-slate-300' => ! $error,
    ])>
        <div class="flex aspect-[4/3] items-center justify-center">
            <img x-show="preview" x-cloak :src="preview" alt="" class="size-full object-cover">
            <div x-show="! preview" class="flex flex-col items-center gap-2 text-slate-400">
                <x-lucide-image class="size-8" aria-hidden="true" />
                <span class="text-sm">No image yet</span>
            </div>
        </div>

        <label class="flex min-h-11 cursor-pointer items-center justify-center gap-2 border-t border-slate-200 bg-white px-4 text-[0.9375rem] font-semibold text-brand-600 transition-colors duration-[120ms] hover:bg-brand-50 focus-within:outline-2 focus-within:outline-brand-600">
            <x-lucide-upload class="size-4" aria-hidden="true" />
            <span x-text="fileName || @js($current ? 'Replace image' : 'Choose image')">{{ $current ? 'Replace image' : 'Choose image' }}</span>
            <input
                type="file"
                id="{{ $id }}"
                name="{{ $name }}"
                accept="image/jpeg,image/png,image/webp"
                class="sr-only"
                aria-describedby="{{ $id }}-hint{{ $error ? ' '.$id.'-error' : '' }}"
                @if ($required) required @endif
                @change="const file = $event.target.files[0]; if (file) { preview = URL.createObjectURL(file); fileName = file.name; }"
            >
        </label>
    </div>

    @if ($error)
        <p id="{{ $id }}-error" class="mt-1.5 text-sm font-medium text-danger">{{ $error }}</p>
    @endif
</div>
