{{-- The title of a code entry card. The accent word is the last word by default, or the first word when accent is "first". --}}
@props(['heading', 'headingId' => null, 'accent' => 'last'])
@php
    $headingWords = preg_split('/\s+/', trim($heading)) ?: [];
    $headingAccentWord = $accent === 'first' ? array_shift($headingWords) : array_pop($headingWords);
    $headingOtherWords = implode(' ', $headingWords);
@endphp
<h3 class="leetcode-card__title" @if ($headingId) id="{{ $headingId }}" @endif>@if ($accent === 'first')<span class="code-entry-card__title-accent">{{ $headingAccentWord }}</span>@if ($headingOtherWords !== ''){{ ' '.$headingOtherWords }}@endif @else @if ($headingOtherWords !== ''){{ $headingOtherWords.' ' }}@endif<span class="code-entry-card__title-accent">{{ $headingAccentWord }}</span>@endif</h3>
