{{-- Image viewer on the project detail page. Without JavaScript the first image is shown. --}}
@props(['project'])
@php
    $slides = $project->images;
    $title = $project->translated('title');
    $slideLabel = fn (int $index): string => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).' / '.str_pad((string) $slides->count(), 2, '0', STR_PAD_LEFT).' - '.str($title)->upper();
    $slideCaption = function (\App\Models\ProjectImage $image) use ($title): string {
        $alt = $image->translated('alt');

        return $alt ? $title.': '.$alt : $title;
    };
@endphp
@if ($slides->isNotEmpty())
    <figure class="project-media" data-project-media>
        <div class="project-media__toolbar">
            <p class="project-media__label">{{ __('projects.detail.media_label', ['title' => str($title)->upper()]) }}</p>
            @if ($project->media_tagline)
                <p class="project-media__tagline">{{ $project->media_tagline }}</p>
            @endif
        </div>

        <div class="project-media__stage">
            @if ($slides->count() > 1)
                <svg class="project-media__notch project-media__notch--previous" viewBox="0 0 34 144" aria-hidden="true" focusable="false">
                    <path d="M0.5 0 L33.5 26 L33.5 118 L0.5 144"/>
                </svg>
                <button type="button" class="project-media__nav project-media__nav--previous" data-project-media-prev aria-label="{{ __('projects.detail.previous_image') }}">
                    <span class="project-media__nav-face">
                        <span class="project-media__nav-arrows">
                            <x-themed-image class="project-icon project-media__nav-icon" :light="'images/projects/icons/imgPreviousImageArrow.svg'" :dark="'images/projects/icons/imgPreviousImageArrow.svg'" />
                            <x-themed-image class="project-icon project-media__nav-icon" :light="'images/projects/icons/imgPreviousImageArrow.svg'" :dark="'images/projects/icons/imgPreviousImageArrow.svg'" />
                        </span>
                    </span>
                </button>
            @endif

            <div class="project-media__viewport">
                @foreach ($slides as $index => $image)
                    <div class="project-media__slide{{ $index === 0 ? ' is-active' : '' }}" data-project-media-slide="{{ $slideLabel($index) }}" data-project-media-caption="{{ $slideCaption($image) }}" @if ($index > 0) aria-hidden="true" inert @endif>
                        <img src="{{ asset($image->path) }}" alt="{{ $image->translated('alt') ?? $title }}" decoding="async">
                    </div>
                @endforeach
            </div>

            @if ($slides->count() > 1)
                <svg class="project-media__notch project-media__notch--next" viewBox="0 0 34 144" aria-hidden="true" focusable="false">
                    <path d="M33.5 0 L0.5 26 L0.5 118 L33.5 144"/>
                </svg>
                <button type="button" class="project-media__nav project-media__nav--next" data-project-media-next aria-label="{{ __('projects.detail.next_image') }}">
                    <span class="project-media__nav-face">
                        <span class="project-media__nav-arrows">
                            <x-themed-image class="project-icon project-media__nav-icon" :light="'images/projects/icons/imgNextImageArrow.svg'" :dark="'images/projects/icons/imgNextImageArrow.svg'" />
                            <x-themed-image class="project-icon project-media__nav-icon" :light="'images/projects/icons/imgNextImageArrow.svg'" :dark="'images/projects/icons/imgNextImageArrow.svg'" />
                        </span>
                    </span>
                </button>
            @endif
        </div>

        <figcaption class="project-media__caption">
            <p class="project-media__caption-text" data-project-media-caption-text>{{ $slideCaption($slides->first()) }}</p>
            <p class="project-media__counter" data-project-media-counter>{{ $slideLabel(0) }}</p>
        </figcaption>
    </figure>
@endif
