{{-- The keyword links next to the search field. Each link keeps the other query values; the selected keyword links back to the unfiltered list. --}}
@props(['keywords', 'selected' => null, 'label'])
<nav class="keyword-filter" aria-label="{{ $label }}">
    <ul class="keyword-filter__list">
        @foreach ($keywords as $keyword)
            @php
                $isSelected = $selected === $keyword;
            @endphp
            <li>
                <a class="keyword-filter__link" href="{{ request()->fullUrlWithQuery(['keyword' => $isSelected ? null : $keyword->value]) }}" @if ($isSelected) aria-current="true" @endif>{{ $keyword->label() }}</a>
            </li>
        @endforeach
    </ul>
</nav>
