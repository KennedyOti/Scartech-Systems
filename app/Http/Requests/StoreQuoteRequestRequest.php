<?php

namespace App\Http\Requests;

use App\Models\QuoteRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequestRequest extends FormRequest
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
            'needs_site_survey' => $this->boolean('needs_site_survey'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', app()->isProduction() ? 'email:rfc,dns' : 'email:rfc', 'max:180'],
            'phone' => ['required', 'string', 'max:32'],
            'company' => ['nullable', 'string', 'max:160'],
            'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where('is_active', true)],
            'product' => ['nullable', 'string', 'max:160'],
            'location' => ['nullable', 'string', 'max:160'],
            'site_type' => ['nullable', Rule::in(QuoteRequest::SITE_TYPES)],
            'timeline' => ['nullable', Rule::in(QuoteRequest::TIMELINES)],
            'needs_site_survey' => ['boolean'],
            'details' => ['required', 'string', 'min:20', 'max:4000'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tell us your name.',
            'email.required' => 'Enter an email address so we can send your quote.',
            'email.email' => 'That email address does not look right. Check it and try again.',
            'phone.required' => 'Enter a phone number we can reach you on.',
            'service_id.exists' => 'Choose a service from the list.',
            'site_type.in' => 'Choose a site type from the list.',
            'timeline.in' => 'Choose a timeline from the list.',
            'details.required' => 'Describe the site and what you need.',
            'details.min' => 'Add a little more detail, at least 20 characters, so we can scope the work.',
            'details.max' => 'Keep the details under 4,000 characters.',
            'website.prohibited' => 'Your request could not be sent.',
        ];
    }
}
