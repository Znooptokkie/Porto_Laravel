{{-- The search pill used in the filter bars. It sits inside a GET form and submits its value as "q". --}}
@props(['label', 'value' => ''])
<label class="search-field">
    <span class="visually-hidden">{{ $label }}</span>
    <input type="search" name="q" value="{{ $value }}" placeholder="{{ $label }}" maxlength="100">
    <button type="submit" class="search-field__submit" aria-label="{{ $label }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="7"/>
            <path d="m20 20-3.5-3.5"/>
        </svg>
    </button>
</label>
