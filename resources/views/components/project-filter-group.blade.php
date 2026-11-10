{{-- One filter group. Desktop shows a trigger that opens a popover; mobile shows the heading inside the filter sheet. --}}
@props(['id', 'label', 'options'])
<div class="project-filter" data-project-filter id="{{ $id }}">
    <button type="button" class="project-filter__trigger" data-project-filter-trigger aria-expanded="false" aria-controls="{{ $id }}-panel">
        <span>{{ $label }}</span>
        <x-themed-image class="project-filter__chevron" :light="'images/projects/icons/imgDropdownChevron.svg'" :dark="'images/projects/icons/imgFilterChevronDark.svg'" />
    </button>

    <p class="project-filter__sheet-heading">{{ $label }}</p>

    <div class="project-filter__panel" id="{{ $id }}-panel" role="group" aria-label="{{ $label }}">
        @foreach ($options as $option)
            <label class="project-filter__option">
                <input type="{{ $option['type'] }}" name="{{ $option['name'] }}" value="{{ $option['value'] }}"@checked($option['checked'])>
                <span class="project-filter__indicator" aria-hidden="true"></span>
                <span>{{ $option['label'] }}</span>
            </label>
        @endforeach
    </div>
</div>
