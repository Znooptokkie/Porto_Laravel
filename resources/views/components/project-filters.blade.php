{{-- The overview filter form. Desktop and tablet show one button per group with a popover; mobile shows a single
     button that opens a bottom sheet containing every group. The same inputs serve both layouts. --}}
@props(['options', 'filters'])
@php
    $checked = fn (string $key, mixed $value): bool => in_array((int) $value, array_map('intval', $filters[$key] ?? []), true);
    $selectedSort = fn (string $key, string $value): bool => ($filters[$key] ?? null) === $value;
@endphp
<form method="GET" action="{{ route('projects') }}" class="project-filters" data-project-filters>
    <button type="button" class="project-filters__mobile-trigger" data-project-sheet-open aria-haspopup="dialog">
        <span>{{ __('projects.filters.open') }}</span>
        <x-themed-image class="project-filter__chevron" :light="'images/figma/projects/icons/imgDropdownChevron.svg'" :dark="'images/figma/projects/icons/imgFilterChevronDark.svg'" />
    </button>

    <dialog class="project-filters__sheet" data-project-sheet aria-label="{{ __('projects.filters.open') }}">
        <div class="project-filters__sheet-header">
            <button type="button" class="project-filters__sheet-handle-button" data-project-sheet-close>
                <x-themed-image class="project-filters__sheet-handle" :light="'images/figma/projects/icons/imgFilterPanelHandle.svg'" :dark="'images/figma/projects/icons/imgFilterPanelHandle.svg'" />
                <span class="visually-hidden">{{ __('projects.filters.close') }}</span>
            </button>
        </div>

        <x-project-filter-group id="filter-year" :label="__('projects.filters.year')" :options="[
            ['type' => 'radio', 'name' => 'year_sort', 'value' => 'asc', 'label' => __('projects.filters.asc'), 'checked' => $selectedSort('year_sort', 'asc')],
            ['type' => 'radio', 'name' => 'year_sort', 'value' => 'desc', 'label' => __('projects.filters.desc'), 'checked' => $selectedSort('year_sort', 'desc')],
            ...collect($options['years'])->map(fn (int $year): array => ['type' => 'checkbox', 'name' => 'years[]', 'value' => $year, 'label' => (string) $year, 'checked' => in_array($year, array_map('intval', $filters['years'] ?? []), true)])->all(),
        ]" />

        <x-project-filter-group id="filter-language" :label="__('projects.filters.language')" :options="$options['languages']->map(fn ($technology): array => ['type' => 'checkbox', 'name' => 'languages[]', 'value' => $technology->id, 'label' => $technology->name, 'checked' => $checked('languages', $technology->id)])->all()" />

        <x-project-filter-group id="filter-framework" :label="__('projects.filters.framework')" :options="$options['frameworks']->map(fn ($technology): array => ['type' => 'checkbox', 'name' => 'frameworks[]', 'value' => $technology->id, 'label' => $technology->name, 'checked' => $checked('frameworks', $technology->id)])->all()" />

        <x-project-filter-group id="filter-alphabetical" :label="__('projects.filters.alphabetical')" :options="[
            ['type' => 'radio', 'name' => 'alpha', 'value' => 'asc', 'label' => __('projects.filters.alpha_asc'), 'checked' => $selectedSort('alpha', 'asc')],
            ['type' => 'radio', 'name' => 'alpha', 'value' => 'desc', 'label' => __('projects.filters.alpha_desc'), 'checked' => $selectedSort('alpha', 'desc')],
        ]" />

        <x-project-filter-group id="filter-favorite" :label="__('projects.filters.favorite')" :options="[
            ['type' => 'radio', 'name' => 'favorite', 'value' => 'most', 'label' => __('projects.filters.most_favorite'), 'checked' => $selectedSort('favorite', 'most')],
            ['type' => 'radio', 'name' => 'favorite', 'value' => 'least', 'label' => __('projects.filters.least_favorite'), 'checked' => $selectedSort('favorite', 'least')],
        ]" />

        <x-project-filter-group id="filter-type" :label="__('projects.filters.type')" :options="$options['types']->map(fn ($type): array => ['type' => 'checkbox', 'name' => 'types[]', 'value' => $type->id, 'label' => $type->translatedName(), 'checked' => $checked('types', $type->id)])->all()" />

        <div class="project-filters__sheet-footer">
            <a class="project-filters__sheet-reset" href="{{ route('projects') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                    <path d="M21 3v5h-5"/>
                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                    <path d="M3 21v-5h5"/>
                </svg>
                {{ __('projects.filters.reset') }}
            </a>
        </div>
    </dialog>

    <a class="project-filters__reset" href="{{ route('projects') }}" aria-label="{{ __('projects.filters.reset') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
            <path d="M21 3v5h-5"/>
            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
            <path d="M3 21v-5h5"/>
        </svg>
    </a>
</form>
