<?php

namespace App\Http\Requests\Portal;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Specifications are typed as "Label: Value" lines and features as one per line; both are stored as JSON.
     */
    protected function prepareForValidation(): void
    {
        $lines = fn (?string $text): array => array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $text))));

        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'remove_datasheet' => $this->boolean('remove_datasheet'),
            'sort_order' => $this->input('sort_order') ?? 0,
            'remove_gallery' => $this->input('remove_gallery', []),
            'features' => $lines($this->input('features_text')),
            'specifications' => array_map(fn (string $line): array => [
                'label' => trim(Str::before($line, ':')),
                'value' => Str::contains($line, ':') ? trim(Str::after($line, ':')) : '',
            ], $lines($this->input('specifications_text'))),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Product|null $product */
        $product = $this->route('product');

        return [
            'product_category_id' => ['required', 'integer', Rule::exists('product_categories', 'id')],
            'name' => ['required', 'string', 'max:160'],
            'slug' => ['required', 'string', 'max:180', Rule::unique('products', 'slug')->ignore($product)],
            'brand' => ['nullable', 'string', 'max:80'],
            'model_number' => ['nullable', 'string', 'max:80'],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:20000'],
            'features_text' => ['nullable', 'string', 'max:5000'],
            'features' => ['array', 'max:30'],
            'features.*' => ['string', 'max:255'],
            'specifications_text' => ['nullable', 'string', 'max:5000'],
            'specifications' => ['array', 'max:40'],
            'specifications.*.label' => ['required', 'string', 'max:120'],
            'specifications.*.value' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery' => ['nullable', 'array', 'max:20'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_gallery' => ['array'],
            'remove_gallery.*' => ['string'],
            'datasheet' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'remove_datasheet' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
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
            'product_category_id.required' => 'Choose a category.',
            'slug.unique' => 'Another product already uses this URL slug. Change the name or the slug.',
            'specifications.*.value.required' => 'Write each specification as "Label: Value", for example "Resolution: 2 MP".',
            'gallery.*.image' => 'Every gallery file must be an image.',
            'gallery.*.max' => 'Each gallery image must be 5 MB or smaller.',
            'datasheet.mimes' => 'The datasheet must be a PDF.',
        ];
    }

    /**
     * The validated attributes that map directly onto product columns.
     *
     * @return array<string, mixed>
     */
    public function productAttributes(): array
    {
        return $this->safe()->except([
            'image', 'gallery', 'remove_gallery', 'datasheet', 'remove_datasheet', 'features_text', 'specifications_text',
        ]);
    }
}
