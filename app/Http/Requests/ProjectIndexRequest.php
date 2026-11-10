<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The filter values are read from the query string; each group is optional.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'year_sort' => ['nullable', Rule::in(['asc', 'desc'])],
            'years' => ['nullable', 'array'],
            'years.*' => ['integer', 'between:1900,2100'],
            'languages' => ['nullable', 'array'],
            'languages.*' => ['integer', Rule::exists('technologies', 'id')],
            'frameworks' => ['nullable', 'array'],
            'frameworks.*' => ['integer', Rule::exists('technologies', 'id')],
            'alpha' => ['nullable', Rule::in(['asc', 'desc'])],
            'favorite' => ['nullable', Rule::in(['most', 'least'])],
            'types' => ['nullable', 'array'],
            'types.*' => ['integer', Rule::exists('project_types', 'id')],
        ];
    }
}
