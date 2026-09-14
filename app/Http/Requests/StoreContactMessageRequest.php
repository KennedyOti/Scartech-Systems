<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:20', 'max:4000'],
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
            'name.max' => 'Keep your name under 120 characters.',
            'email.required' => 'Enter an email address so we can reply.',
            'email.email' => 'That email address does not look right. Check it and try again.',
            'phone.required' => 'Enter a phone number we can reach you on.',
            'phone.max' => 'That phone number is too long.',
            'subject.required' => 'Choose what your message is about.',
            'message.required' => 'Tell us what you need.',
            'message.min' => 'Add a little more detail, at least 20 characters, so we can help.',
            'message.max' => 'Keep your message under 4,000 characters.',
            'website.prohibited' => 'Your message could not be sent.',
        ];
    }
}
