{{-- Image viewer on the project detail page. Without JavaScript the first image is shown. --}}
@props(['project'])
@php
    $title = $project->translated('title');
    $counterLabel = fn (int $position, int $total): string => str_pad((string) $position, 2, '0', STR_PAD_LEFT).' / '.str_pad((string) $total, 2, '0', STR_PAD_LEFT).' - '.str($title)->upper();
    $captionFor = fn (?string $alt): string => $alt ? $title.': '.$alt : $title;

    // One entry per photo, or per cropped mobile photo that replaces a photo on small screens. Each entry has its own alt text and caption.
    $sources = [];

    foreach ($project->images as $image) {
        $alt = $image->translated('alt');

        if (empty($image->mobile_photos)) {
            $sources[] = ['path' => $image->path, 'alt' => $alt ?? $title, 'caption' => $captionFor($alt), 'scope' => 'both'];

            continue;
        }

        $sources[] = ['path' => $image->path, 'alt' => $alt ?? $title, 'caption' => $captionFor($alt), 'scope' => 'desktop'];

        foreach ($image->mobile_photos as $mobilePhoto) {
            $mobileAlt = $image->mobilePhotoAlt($mobilePhoto) ?? $alt;

            $sources[] = ['path' => $mobilePhoto['path'], 'alt' => $mobileAlt ?? $title, 'caption' => $captionFor($mobileAlt), 'scope' => 'mobile'];
        }
    }

    $desktopTotal = collect($sources)->where('scope', '!=', 'mobile')->count();
    $mobileTotal = collect($sources)->where('scope', '!=', 'desktop')->count();
    $desktopPosition = 0;
    $mobilePosition = 0;
    $slides = [];

    foreach ($sources as $source) {
        $counterDesktop = null;
        $counterMobile = null;

        if ($source['scope'] !== 'mobile') {
            $counterDesktop = $counterLabel(++$desktopPosition, $desktopTotal);
        }

        if ($source['scope'] !== 'desktop') {
            $counterMobile = $counterLabel(++$mobilePosition, $mobileTotal);
        }

        $slides[] = $source + ['counterDesktop' => $counterDesktop, 'counterMobile' => $counterMobile];
    }

    $slideCount = count($slides);
@endphp
@if ($slideCount > 0)
    <figure class="project-media" data-project-media>
        <div class="project-media__toolbar">
            <p class="project-media__label">{{ __('projects.detail.media_label', ['title' => str($title)->upper()]) }}</p>
            @if ($project->media_tagline)
                <p class="project-media__tagline">{{ $project->media_tagline }}</p>
            @endif
        </div>

        <div class="project-media__stage">
            @if ($slideCount > 1)
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
                @foreach ($slides as $index => $slide)
                    <div class="project-media__slide{{ $index === 0 ? ' is-active' : '' }}" data-project-media-scope="{{ $slide['scope'] }}" data-project-media-counter-desktop="{{ $slide['counterDesktop'] }}" data-project-media-counter-mobile="{{ $slide['counterMobile'] }}" data-project-media-caption="{{ $slide['caption'] }}" @if ($index > 0) aria-hidden="true" inert @endif>
                        <img src="{{ asset(str_replace(' ', '%20', $slide['path'])) }}" alt="{{ $slide['alt'] }}" decoding="async">
                    </div>
                @endforeach
            </div>

            @if ($slideCount > 1)
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
            <p class="project-media__caption-text" data-project-media-caption-text>{{ $slides[0]['caption'] }}</p>
            <p class="project-media__counter" data-project-media-counter>{{ $slides[0]['counterDesktop'] }}</p>
        </figcaption>
    </figure>
@endif
