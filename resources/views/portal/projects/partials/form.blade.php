@php
    $selectedServices = array_map('intval', old('services', $project->exists ? $project->services->pluck('id')->all() : []));
@endphp

@if ($errors->any())
    <x-alert type="error" class="mb-6">Some details need attention. Check the highlighted fields below.</x-alert>
@endif

<div class="grid gap-6 lg:grid-cols-12">
    <div class="space-y-6 lg:col-span-8">
        <x-portal::card title="Project details">
            <x-form.input name="title" label="Title" :value="$project->title" required maxlength="160" />
            <x-form.input name="slug" label="URL slug" :value="$project->slug" optional hint="Leave blank to create one from the title." maxlength="180" />

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="sector" label="Sector" :value="$project->sector" required list="sector-options" maxlength="80" />
                <datalist id="sector-options">
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector }}"></option>
                    @endforeach
                </datalist>
                <x-form.input name="location" label="Location" :value="$project->location" required maxlength="120" />
                <x-form.input name="client_name" label="Client name" :value="$project->client_name" optional hint="Only publish names the client has approved." maxlength="160" />
                <x-form.input name="year" label="Year completed" type="number" :value="$project->year" optional min="1990" max="{{ now()->year + 1 }}" />
            </div>

            <x-form.textarea name="summary" label="Summary" :value="$project->summary" rows="3" required hint="One or two sentences shown on project cards." maxlength="500" />
        </x-portal::card>

        <x-portal::card title="Case study" description="Each section is shown on the project page only when it has content.">
            <x-form.textarea name="challenge" label="The challenge" :value="$project->challenge" rows="4" optional />
            <x-form.textarea name="solution" label="Our solution" :value="$project->solution" rows="4" optional />
            <x-form.textarea name="outcome" label="The outcome" :value="$project->outcome" rows="4" optional />
        </x-portal::card>

        <x-portal::card title="Site photographs">
            <x-portal::gallery-input :images="$project->gallery ?? []" label="Gallery" />
        </x-portal::card>

        <x-portal::card title="Search engines" description="Optional. The title and summary are used when these are blank.">
            <x-form.input name="meta_title" label="Meta title" :value="$project->meta_title" optional maxlength="255" />
            <x-form.textarea name="meta_description" label="Meta description" :value="$project->meta_description" rows="2" optional maxlength="255" />
        </x-portal::card>
    </div>

    <div class="space-y-6 lg:col-span-4">
        <x-portal::card title="Publishing">
            <x-form.checkbox name="is_featured" label="Feature on the home page" :checked="$project->is_featured" />
            <x-form.input name="sort_order" label="Display order" type="number" :value="$project->sort_order ?? 0" min="0" hint="Lower numbers appear first." />
        </x-portal::card>

        <x-portal::card title="Cover image">
            <x-portal::image-input
                name="cover_image"
                label="Cover photograph"
                :current="$project->cover_image ? $project->image_url : null"
                :required="! $project->exists"
            />
        </x-portal::card>

        <x-portal::card title="Services delivered">
            <fieldset>
                <legend class="sr-only">Services delivered</legend>
                <div class="space-y-2.5">
                    @foreach ($services as $service)
                        <label class="flex items-start gap-3 text-[0.9375rem] text-slate-700">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" @checked(in_array($service->id, $selectedServices, true)) class="mt-0.5 size-5 shrink-0 rounded-sm border-slate-300 accent-brand-600">
                            {{ $service->name }}
                        </label>
                    @endforeach
                </div>
            </fieldset>
            @error('services.*')
                <p class="text-sm font-medium text-danger">{{ $message }}</p>
            @enderror
        </x-portal::card>
    </div>
</div>
