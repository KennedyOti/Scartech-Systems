@php
    $specificationsText = collect($product->specifications ?? [])
        ->map(fn (array $row): string => $row['label'].': '.$row['value'])
        ->implode("\n");
    $featuresText = implode("\n", $product->features ?? []);
    $specificationError = collect($errors->get('specifications.*'))->flatten()->first();
    $featureError = collect($errors->get('features.*'))->flatten()->first() ?? $errors->first('features');
@endphp

@if ($errors->any())
    <x-alert type="error" class="mb-6">Some details need attention. Check the highlighted fields below.</x-alert>
@endif

<div class="grid gap-6 lg:grid-cols-12">
    <div class="space-y-6 lg:col-span-8">
        <x-portal::card title="Product details">
            <x-form.input name="name" label="Product name" :value="$product->name" required maxlength="160" />
            <x-form.input name="slug" label="URL slug" :value="$product->slug" optional hint="Leave blank to create one from the name." maxlength="180" />

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.select name="product_category_id" label="Category" :options="$categories" :value="$product->product_category_id" required />
                <x-form.input name="brand" label="Brand" :value="$product->brand" optional maxlength="80" />
                <x-form.input name="model_number" label="Model number" :value="$product->model_number" optional maxlength="80" />
            </div>

            <x-form.textarea name="summary" label="Summary" :value="$product->summary" rows="3" required hint="One or two sentences shown on product cards." maxlength="500" />
            <x-form.textarea name="description" label="Description" :value="$product->description" rows="6" optional hint="Basic HTML is allowed, for example <p>, <ul> and <strong>." />
        </x-portal::card>

        <x-portal::card title="Features and specifications">
            <div>
                <x-form.textarea name="features_text" label="Key features" :value="$featuresText" rows="5" optional hint="One feature per line." />
                @if ($featureError)
                    <p class="mt-1.5 text-sm font-medium text-danger">{{ $featureError }}</p>
                @endif
            </div>
            <div>
                <x-form.textarea name="specifications_text" label="Specifications" :value="$specificationsText" rows="6" optional hint="One per line, written as Label: Value. For example, Resolution: 2 MP." class="font-mono text-[0.875rem]" />
                @if ($specificationError)
                    <p class="mt-1.5 text-sm font-medium text-danger">{{ $specificationError }}</p>
                @endif
            </div>
        </x-portal::card>

        <x-portal::card title="More photographs">
            <x-portal::gallery-input :images="$product->gallery ?? []" label="Gallery" />
        </x-portal::card>

        <x-portal::card title="Search engines" description="Optional. The name and summary are used when these are blank.">
            <x-form.input name="meta_title" label="Meta title" :value="$product->meta_title" optional maxlength="255" />
            <x-form.textarea name="meta_description" label="Meta description" :value="$product->meta_description" rows="2" optional maxlength="255" />
        </x-portal::card>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <x-portal::card title="Publishing">
            <x-form.checkbox name="is_active" label="Live on the website" hint="Hidden products are kept here but not shown to visitors." :checked="$product->is_active" />
            <x-form.checkbox name="is_featured" label="Feature on the home page" :checked="$product->is_featured" />
            <x-form.input name="sort_order" label="Display order" type="number" :value="$product->sort_order ?? 0" min="0" hint="Lower numbers appear first." />
        </x-portal::card>

        <x-portal::card title="Main image">
            <x-portal::image-input name="image" label="Product photograph" :current="$product->image ? $product->image_url : null" hint="JPG, PNG or WebP, up to 5 MB. A plain background works best." />
        </x-portal::card>

        <x-portal::card title="Datasheet">
            @if ($product->datasheet_path)
                <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 px-3 py-2.5">
                    <a href="{{ asset($product->datasheet_path) }}" target="_blank" rel="noopener" class="flex min-w-0 items-center gap-2 text-[0.9375rem] font-medium text-brand-600 hover:text-brand-700">
                        <x-lucide-file-text class="size-5 shrink-0" aria-hidden="true" />
                        <span class="truncate">{{ basename($product->datasheet_path) }}</span>
                    </a>
                </div>
                <x-form.checkbox name="remove_datasheet" label="Remove this datasheet" />
            @endif

            <div>
                <label for="field-datasheet" class="block text-[0.9375rem] font-medium text-slate-900">
                    {{ $product->datasheet_path ? 'Replace with a new PDF' : 'Upload PDF' }}
                    <span class="font-normal text-slate-500">(optional)</span>
                </label>
                <input type="file" id="field-datasheet" name="datasheet" accept="application/pdf" class="mt-2 block w-full text-sm text-slate-700 file:mr-3 file:min-h-10 file:cursor-pointer file:rounded-md file:border file:border-slate-300 file:bg-white file:px-4 file:text-sm file:font-semibold file:text-slate-900 hover:file:bg-slate-50">
                <p class="mt-1 text-sm text-slate-500">PDF, up to 10 MB.</p>
                @error('datasheet')
                    <p class="mt-1.5 text-sm font-medium text-danger">{{ $message }}</p>
                @enderror
            </div>
        </x-portal::card>
    </div>
</div>
