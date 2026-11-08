@props(['internship'])
@php
    $logo = config('portfolio.internship_logos.'.$internship['name']);
@endphp
<article class="internship-card">
    <div class="internship-card__org">
        <div class="internship-card__logo" aria-hidden="true">
            <x-themed-image :light="$logo['light']" :dark="$logo['dark']" />
        </div>
        <div>
            <h4 class="internship-card__name">{{ $internship['name'] }}</h4>
            <span class="tag">{{ $internship['tag'] }}</span>
        </div>
    </div>
    <p class="internship-card__text">{!! $internship['text'] !!}</p>
</article>
