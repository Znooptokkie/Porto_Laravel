@props(['eyebrow', 'title', 'accent', 'aside' => null])
<div class="section-heading">
    <div>
        <p class="section-heading__eyebrow">{{ $eyebrow }}</p>
        <h2 class="section-heading__title">{{ $title }} <span>{{ $accent }}</span></h2>
    </div>
    @if ($aside)
        <p class="section-heading__aside">{{ $aside }}</p>
    @endif
</div>
