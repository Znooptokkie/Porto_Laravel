<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Sets the locale before validation so the error messages match the page language.
     */
    protected function prepareForValidation(): void
    {
        app()->setLocale($this->cookie('locale') === 'en' ? 'en' : 'nl');
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('about.contact.errors.name_required'),
            'name.max' => __('about.contact.errors.too_long'),
            'email.required' => __('about.contact.errors.email_required'),
            'email.email' => __('about.contact.errors.email_invalid'),
            'email.max' => __('about.contact.errors.too_long'),
            'message.required' => __('about.contact.errors.message_required'),
            'message.max' => __('about.contact.errors.too_long'),
        ];
    }
}
