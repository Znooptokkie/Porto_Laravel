{{-- One card on the education page. The default slot holds the story, the "details" slot the facts and lists. --}}
@props(['icon', 'marker', 'markerWidth' => 49.5, 'title', 'period', 'modifier' => null])
<article class="education-card{{ $modifier ? ' education-card--'.$modifier : '' }}">
    <header class="education-card__heading">
        <span class="education-card__badge">
            @if (str_ends_with($icon, '.svg'))
                <x-themed-image :light="$icon" :dark="$icon" class="education-card__icon" />
            @else
                <x-themed-image :light="$icon" :dark="$icon" accent class="education-card__icon" />
            @endif
        </span>
        <h3 class="education-card__title">{{ $title }}</h3>
        <p class="education-card__period">{{ $period }}</p>
        <span class="education-card__marker" style="width: {{ $markerWidth }}px">
            <x-themed-image :light="$marker" :dark="$marker" />
        </span>
    </header>
    <div class="education-card__body">
        <div class="education-card__story">{{ $slot }}</div>
        <div class="education-card__divider" aria-hidden="true"></div>
        <div class="education-card__details">{{ $details }}</div>
    </div>
</article>
