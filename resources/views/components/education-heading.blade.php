{{-- Section heading of the education page: mono eyebrow with accent rule, title with accent word, mono aside. --}}
@props(['headingId', 'eyebrow', 'title', 'accent', 'aside'])
<div class="education-heading">
    <div class="education-heading__main">
        <p class="education-eyebrow">{{ $eyebrow }}</p>
        <h2 class="education-heading__title" id="{{ $headingId }}">{{ $title }} <span>{{ $accent }}</span></h2>
    </div>
    <p class="education-heading__aside">{{ $aside }}</p>
</div>
