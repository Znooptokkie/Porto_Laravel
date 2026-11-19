<?php

namespace App\Http\Requests;

use App\Enums\LinuxCommandKeyword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LinuxCommandsIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The search term and the keyword are read from the query string and are optional.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'keyword' => ['nullable', Rule::enum(LinuxCommandKeyword::class)],
        ];
    }
}
