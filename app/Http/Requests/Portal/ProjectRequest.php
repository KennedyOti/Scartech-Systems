<?php

namespace App\Http\Requests\Portal;

use App\Models\Project;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('title', '')),
            'is_featured' => $this->boolean('is_featured'),
            'sort_order' => $this->input('sort_order') ?? 0,
            'services' => $this->input('services', []),
            'remove_gallery' => $this->input('remove_gallery', []),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Project|null $project */
        $project = $this->route('project');

        return [
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['required', 'string', 'max:180', Rule::unique('projects', 'slug')->ignore($project)],
            'client_name' => ['nullable', 'string', 'max:160'],
            'sector' => ['required', 'string', 'max:80'],
            'location' => ['required', 'string', 'max:120'],
            'year' => ['nullable', 'integer', 'min:1990', 'max:'.(now()->year + 1)],
            'summary' => ['required', 'string', 'max:500'],
            'challenge' => ['nullable', 'string', 'max:5000'],
            'solution' => ['nullable', 'string', 'max:5000'],
            'outcome' => ['nullable', 'string', 'max:5000'],
            'cover_image' => [$project ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery' => ['nullable', 'array', 'max:20'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_gallery' => ['array'],
            'remove_gallery.*' => ['string'],
            'services' => ['array'],
            'services.*' => ['integer', Rule::exists('services', 'id')],
            'is_featured' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:65535'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.unique' => 'Another project already uses this URL slug. Change the title or the slug.',
            'cover_image.required' => 'Upload a cover image for the project.',
            'gallery.*.image' => 'Every gallery file must be an image.',
            'gallery.*.max' => 'Each gallery image must be 5 MB or smaller.',
        ];
    }

    /**
     * The validated attributes that map directly onto project columns.
     *
     * @return array<string, mixed>
     */
    public function projectAttributes(): array
    {
        return $this->safe()->except(['cover_image', 'gallery', 'remove_gallery', 'services']);
    }
}
