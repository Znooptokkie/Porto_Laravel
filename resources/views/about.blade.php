@extends('layouts.app')

@section('content')
    <section class="container-max education-intro" aria-labelledby="about-title">
        <div class="education-intro__text">
            <p class="education-eyebrow">{{ __('about.intro.label') }}</p>
            <h1 class="education-intro__title" id="about-title">{{ __('about.intro.title') }} <span>{{ __('about.intro.title_accent') }}</span></h1>
            <p class="education-intro__lead">{{ __('about.intro.lead') }}</p>
        </div>
        <div class="education-intro__summary">
            <p class="education-intro__summary-value">{{ __('about.intro.summary_value') }}</p>
            <p class="education-intro__summary-label">{{ __('about.intro.summary_label') }}</p>
        </div>
    </section>

    <section class="container-max about-section" aria-labelledby="about-personality-heading">
        <x-education-heading
            heading-id="about-personality-heading"
            :eyebrow="__('about.personality.eyebrow')"
            :title="__('about.personality.title')"
            :accent="__('about.personality.title_accent')"
            :aside="__('about.personality.aside')" />

        <div class="about-card about-story" style="--external-link-icon: url('{{ asset('images/ui/timeline/light/externalLinkBoxIcon.svg') }}')">
            @foreach (__('about.personality.paragraphs') as $paragraph)
                <p>{!! $paragraph !!}</p>
            @endforeach
        </div>
    </section>

    <section class="container-max about-section about-section--spaced" aria-labelledby="about-work-heading">
        <x-education-heading
            heading-id="about-work-heading"
            :eyebrow="__('about.work.eyebrow')"
            :title="__('about.work.title')"
            :accent="__('about.work.title_accent')"
            :aside="__('about.work.aside')" />

        <div class="about-card about-story" style="--external-link-icon: url('{{ asset('images/ui/timeline/light/externalLinkBoxIcon.svg') }}')">
            @foreach (__('about.work.paragraphs') as $paragraph)
                <p>{!! $paragraph !!}</p>
            @endforeach
        </div>

        <div class="about-accordions">
            @foreach (__('about.work.accordions') as $accordion)
                <details class="about-accordion" @if ($loop->first) open @endif>
                    <summary class="about-accordion__summary">
                        <span class="education-card__badge">
                            <x-themed-image :light="$accordion['icon']" :dark="$accordion['icon']" accent class="education-card__icon" />
                        </span>
                        <span class="about-accordion__title">{{ $accordion['title'] }}</span>
                        <span class="about-accordion__chevron" aria-hidden="true">
                            <x-themed-image :light="'images/projects/icons/imgDropdownChevron.svg'" :dark="'images/projects/icons/imgDropdownChevron.svg'" />
                        </span>
                    </summary>

                    <div class="about-accordion__body">
                        @foreach ($accordion['items'] as $item)
                            <div class="about-accordion__item">
                                <p class="about-accordion__text">{{ $item['text'] }}</p>
                                <ul class="about-accordion__links">
                                    <li>
                                        <a class="about-accordion__link" href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer">{{ $item['url'] }}<span class="visually-hidden"> ({{ __('site.footer.open_new_tab') }})</span></a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endforeach
        </div>
    </section>

    <section class="container-max about-section about-section--spaced" id="about-contact" aria-labelledby="about-contact-heading">
        <x-education-heading
            heading-id="about-contact-heading"
            :eyebrow="__('about.contact.eyebrow')"
            :title="__('about.contact.title')"
            :accent="__('about.contact.title_accent')"
            :aside="__('about.contact.aside')" />

        @if (session('contactStatus') === 'sent')
            <p class="about-contact__status" role="status">{{ __('about.contact.sent') }}</p>
        @endif

        <form class="about-contact" method="POST" action="{{ route('about.contact') }}">
            @csrf
            {{-- Honeypot: hidden from people, filled in only by bots. --}}
            <div class="visually-hidden" aria-hidden="true">
                <label for="about-contact-website">{{ __('about.contact.labels.website') }}</label>
                <input id="about-contact-website" name="website" type="text" tabindex="-1" autocomplete="off">
            </div>
            <div class="about-contact__field">
                <label class="about-contact__label" for="about-contact-name">{{ __('about.contact.labels.name') }}</label>
                <input class="about-contact__input" id="about-contact-name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required @error('name') aria-invalid="true" aria-describedby="about-contact-name-error" @enderror>
                @error('name')
                    <p class="about-contact__error" id="about-contact-name-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="about-contact__field">
                <label class="about-contact__label" for="about-contact-email">{{ __('about.contact.labels.email') }}</label>
                <input class="about-contact__input" id="about-contact-email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required @error('email') aria-invalid="true" aria-describedby="about-contact-email-error" @enderror>
                @error('email')
                    <p class="about-contact__error" id="about-contact-email-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="about-contact__field">
                <label class="about-contact__label" for="about-contact-message">{{ __('about.contact.labels.message') }}</label>
                <textarea class="about-contact__input about-contact__input--message" id="about-contact-message" name="message" rows="6" required @error('message') aria-invalid="true" aria-describedby="about-contact-message-error" @enderror>{{ old('message') }}</textarea>
                @error('message')
                    <p class="about-contact__error" id="about-contact-message-error">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="button button--primary about-contact__submit">
                <span>{{ __('about.contact.submit') }}</span>
                <x-themed-image :light="'images/home/light/externalLinkIcon.svg'" :dark="'images/home/light/externalLinkIcon.svg'" />
            </button>
        </form>
    </section>
@endsection
