{{-- One project on the overview. Cards alternate: with details-first the text sits left on desktop and tablet. --}}
@props(['project', 'total', 'detailsFirst' => false])
@php
    $number = str_pad((string) $project->sort_order, 2, '0', STR_PAD_LEFT);
    $totalLabel = str_pad((string) $total, 2, '0', STR_PAD_LEFT);
    $title = $project->translated('title');
    $photos = $project->images->take(4)->values();
@endphp
<article class="project-card{{ $detailsFirst ? ' project-card--details-first' : '' }}" aria-labelledby="project-{{ $project->id }}-title">
    <div class="project-card__media">
        @foreach ($photos as $photo)
            <div class="project-card__image">
                <img src="{{ asset($photo->path) }}" alt="{{ $photo->alt ?? $title }}" loading="lazy" decoding="async">
            </div>
        @endforeach
    </div>

    <div class="project-card__details">
        <div class="project-card__meta">
            <p class="project-card__category">{{ $project->translated('category') }} <span>| {{ $project->periodLabel() }}</span></p>
            <p class="project-card__number">
                <span>{{ $number }} / {{ $totalLabel }}</span>
                <x-project-progress :position="$project->sort_order" :total="$total" />
            </p>
        </div>

        <div class="project-card__heading">
            <h3 class="project-card__title" id="project-{{ $project->id }}-title">{{ $title }}</h3>
            <x-project-status :status="$project->status" />
        </div>

        <p class="project-card__text">{{ $project->accented('summary') }}</p>

        <div class="project-card__footer">
            <ul class="project-tags" aria-label="{{ __('projects.detail.technologies') }}">
                @foreach ($project->cardTechnologies as $technology)
                    <li class="project-tag">{{ $technology->name }}</li>
                @endforeach
            </ul>

            <a class="project-card__action{{ $project->is_favorite ? ' project-card__action--featured' : '' }}" href="{{ route('projects.show', $project) }}">
                {{ __('projects.card.view') }}
                <x-themed-image class="project-icon project-card__icon" :light="$project->is_favorite ? 'images/projects/icons/imgOpenProjectButton.svg' : 'images/projects/icons/imgOpenProjectButton1.svg'" :dark="$project->is_favorite ? 'images/projects/icons/imgOpenProjectButton.svg' : 'images/projects/icons/imgOpenProjectButton1.svg'" />
            </a>
        </div>
    </div>
</article>
