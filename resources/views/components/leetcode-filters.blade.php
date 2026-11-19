{{-- The LeetCode filter form, built like the projects overview: one popover per group on desktop and tablet, one bottom sheet on mobile. The search field sits after the groups. --}}
@props(['filters'])
@php
    use App\Enums\LeetcodeLanguageFilter;
    use App\Enums\LeetcodeMetricFilter;
    use App\Enums\LeetcodeRatingFilter;

    $selectedValues = fn (string $key): array => array_map('strval', $filters[$key] ?? []);
    $radioOptions = fn (string $key, array $cases): array => array_map(
        fn (LeetcodeRatingFilter|LeetcodeMetricFilter $option): array => [
            'type' => 'radio',
            'name' => $key,
            'value' => $option->value,
            'label' => $option instanceof LeetcodeRatingFilter ? $option->label() : $option->label($key === 'runtime' ? 'ms' : 'MB'),
            'checked' => ($filters[$key] ?? null) === $option->value,
        ],
        $cases,
    );
    $languageOptions = array_map(
        fn (LeetcodeLanguageFilter $language): array => ['type' => 'checkbox', 'name' => 'languages[]', 'value' => $language->value, 'label' => $language->label(), 'checked' => in_array($language->value, $selectedValues('languages'), true)],
        LeetcodeLanguageFilter::cases(),
    );
    $resetIcon = '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M3 21v-5h5"/>';
@endphp
<form method="GET" action="{{ route('leetcode') }}" class="project-filters" data-project-filters>
    <button type="button" class="project-filters__mobile-trigger" data-project-sheet-open aria-haspopup="dialog">
        <span>{{ __('leetcode.filters.open') }}</span>
        <x-themed-image class="project-filter__chevron" :light="'images/projects/icons/imgDropdownChevron.svg'" :dark="'images/projects/icons/imgFilterChevronDark.svg'" />
    </button>

    <dialog class="project-filters__sheet" data-project-sheet aria-label="{{ __('leetcode.filters.open') }}">
        <div class="project-filters__sheet-header">
            <button type="button" class="project-filters__sheet-handle-button" data-project-sheet-close>
                <x-themed-image class="project-filters__sheet-handle" :light="'images/projects/icons/imgFilterPanelHandle.svg'" :dark="'images/projects/icons/imgFilterPanelHandle.svg'" />
                <span class="visually-hidden">{{ __('leetcode.filters.close') }}</span>
            </button>
        </div>

        <div class="leetcode-filters__sheet-body">
        <x-project-filter-group id="filter-leetcode-language" :label="__('leetcode.filters.language')" :options="$languageOptions" />

        <x-project-filter-group id="filter-leetcode-rating" :label="__('leetcode.filters.rating')" :options="$radioOptions('rating', LeetcodeRatingFilter::cases())" />

        <x-project-filter-group id="filter-leetcode-difficulty" :label="__('leetcode.filters.difficulty')" :options="collect(['easy', 'medium', 'hard'])->map(fn (string $difficulty): array => ['type' => 'checkbox', 'name' => 'difficulties[]', 'value' => $difficulty, 'label' => __('leetcode.difficulty.'.$difficulty), 'checked' => in_array($difficulty, $selectedValues('difficulties'), true)])->all()" />

        <x-project-filter-group id="filter-leetcode-runtime" :label="__('leetcode.filters.runtime')" :options="$radioOptions('runtime', LeetcodeMetricFilter::cases())" />

        <x-project-filter-group id="filter-leetcode-memory" :label="__('leetcode.filters.memory')" :options="$radioOptions('memory', LeetcodeMetricFilter::cases())" />

        <div class="project-filters__sheet-footer">
            <a class="project-filters__sheet-reset" href="{{ route('leetcode') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">{!! $resetIcon !!}</svg>
                {{ __('leetcode.filters.reset') }}
            </a>
        </div>
        </div>
    </dialog>

    <x-search-field :label="__('leetcode.filters.search')" :value="$filters['q'] ?? ''" />

    <a class="project-filters__reset" href="{{ route('leetcode') }}" aria-label="{{ __('leetcode.filters.reset') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">{!! $resetIcon !!}</svg>
    </a>
</form>
