@props([
    'images' => [], // stored paths
    'label' => 'Gallery',
])

@php
    $uploadError = collect($errors->get('gallery.*'))->flatten()->first() ?? $errors->first('gallery');
    $removed = old('remove_gallery', []);
@endphp

<div x-data="{ previews: [] }">
    <p class="block text-[0.9375rem] font-medium text-slate-900">{{ $label }}</p>
    <p class="mt-1 text-sm text-slate-500">Add up to 20 photographs. Tick an existing photo to remove it when you save.</p>

    @if (count($images) > 0)
        <ul class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ($images as $index => $path)
                <li>
                    <label class="group relative block cursor-pointer overflow-hidden rounded-md border border-slate-200 has-[:checked]:border-danger">
                        <img src="{{ asset($path) }}" alt="" loading="lazy" class="aspect-[4/3] w-full object-cover transition-opacity duration-[120ms] group-has-[:checked]:opacity-40">
                        <span class="flex items-center gap-2 border-t border-slate-200 bg-white px-2.5 py-2 text-sm text-slate-700 group-has-[:checked]:text-danger">
                            <input type="checkbox" name="remove_gallery[]" value="{{ $path }}" @checked(in_array($path, $removed, true)) class="size-4 accent-danger">
                            Remove
                        </span>
                    </label>
                </li>
            @endforeach
        </ul>
    @endif

    <label class="mt-3 flex min-h-20 cursor-pointer flex-col items-center justify-center gap-1 rounded-md border border-dashed border-slate-300 bg-slate-25 px-4 py-4 text-center transition-colors duration-[120ms] hover:border-slate-400 hover:bg-slate-50 focus-within:outline-2 focus-within:outline-brand-600">
        <span class="inline-flex items-center gap-2 text-[0.9375rem] font-semibold text-brand-600">
            <x-lucide-image-plus class="size-5" aria-hidden="true" />
            Add photographs
        </span>
        <span class="text-sm text-slate-500">JPG, PNG or WebP, up to 5 MB each</span>
        <input
            type="file"
            name="gallery[]"
            multiple
            accept="image/jpeg,image/png,image/webp"
            class="sr-only"
            @change="previews = [...$event.target.files].map((file) => URL.createObjectURL(file))"
        >
    </label>

    <template x-if="previews.length">
        <div class="mt-3">
            <p class="text-sm font-medium text-slate-700"><span x-text="previews.length"></span> new photo(s) will be added</p>
            <ul class="mt-2 grid grid-cols-3 gap-2 sm:grid-cols-6">
                <template x-for="src in previews" :key="src">
                    <li><img :src="src" alt="" class="aspect-square w-full rounded-md border border-slate-200 object-cover"></li>
                </template>
            </ul>
        </div>
    </template>

    @if ($uploadError)
        <p class="mt-1.5 text-sm font-medium text-danger">{{ $uploadError }}</p>
    @endif
</div>
