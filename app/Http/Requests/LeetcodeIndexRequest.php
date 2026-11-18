<?php

namespace App\Http\Requests;

use App\Enums\LeetcodeLanguageFilter;
use App\Enums\LeetcodeMetricFilter;
use App\Enums\LeetcodeRatingFilter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeetcodeIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The search term and filter values are read from the query string; each group is optional.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'languages' => ['nullable', 'array'],
            'languages.*' => [Rule::enum(LeetcodeLanguageFilter::class)],
            'difficulties' => ['nullable', 'array'],
            'difficulties.*' => ['string', Rule::in(['easy', 'medium', 'hard'])],
            'rating' => ['nullable', Rule::enum(LeetcodeRatingFilter::class)],
            'runtime' => ['nullable', Rule::enum(LeetcodeMetricFilter::class)],
            'memory' => ['nullable', Rule::enum(LeetcodeMetricFilter::class)],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
