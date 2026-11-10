@props(['number', 'chapter', 'milestone', 'progress', 'icon'])
<li class="timeline-chapter" style="--external-link-icon: url('{{ asset('images/ui/timeline/light/externalLinkBoxIcon.svg') }}')">
    <div class="timeline-chapter__marker">
        <x-themed-image class="timeline-chapter__dot" :light="$milestone['light']" :dark="$milestone['dark']" />
        <p class="timeline-chapter__number">{{ $number }}</p>
        <p class="timeline-chapter__label">{{ $chapter['label'] }}</p>
    </div>

    <section class="story-card" aria-labelledby="chapter-{{ $number }}-title">
        <header class="story-card__head">
            <span class="story-card__icon">
                <x-themed-image :light="$icon['light']" :dark="$icon['dark']" />
            </span>
            <h3 class="story-card__title" id="chapter-{{ $number }}-title">{{ $chapter['title'] }}</h3>
            <span class="story-card__progress">
                <x-themed-image :light="$progress['light']" :dark="$progress['dark']" />
            </span>
        </header>

        @isset($chapter['internships'])
            <div class="internships">
                @foreach ($chapter['internships'] as $internship)
                    <x-internship-card :internship="$internship" />
                @endforeach
            </div>
        @else
            <div class="story-card__text">
                @foreach ($chapter['paragraphs'] as $paragraph)
                    <p>{!! $paragraph !!}</p>
                @endforeach
            </div>
        @endisset
    </section>
</li>
