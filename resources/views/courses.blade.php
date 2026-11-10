@extends('layouts.app')

@section('content')
    @php
        $diplomaVisuals = [
            ['icon' => 'images/courses/diplomaIcon1.svg', 'marker' => 'images/courses/progressMarker1.svg', 'completion' => 'images/courses/completion1.svg', 'modifier' => 'tall'],
            ['icon' => 'images/courses/diplomaIcon2.svg', 'marker' => 'images/courses/progressMarker2.svg', 'completion' => 'images/courses/completion2.svg', 'modifier' => 'tall'],
            ['icon' => 'images/courses/educationIcon1.png', 'marker' => 'images/courses/progressMarker3.svg', 'completion' => 'images/courses/completion2.svg', 'modifier' => 'tall'],
        ];
        $certificateVisuals = [
            ['icon' => 'images/courses/educationIcon2.png', 'marker' => 'images/courses/progressMarker4.svg', 'markerWidth' => 33, 'modifier' => 'tall'],
            ['icon' => 'images/courses/educationIcon3.png', 'marker' => 'images/courses/progressMarker5.svg', 'markerWidth' => 33, 'modifier' => 'compact'],
        ];
    @endphp

    <section class="container-max education-intro" aria-labelledby="courses-title">
        <div class="education-intro__text">
            <p class="education-eyebrow">{{ __('courses.intro.label') }}</p>
            <h1 class="education-intro__title" id="courses-title">{{ __('courses.intro.title') }} <span>{{ __('courses.intro.title_accent') }}</span></h1>
            <p class="education-intro__lead">{{ __('courses.intro.lead') }}</p>
        </div>
        <div class="education-intro__summary">
            <p class="education-intro__summary-value">{{ __('courses.intro.summary_value') }}</p>
            <p class="education-intro__summary-label">{{ __('courses.intro.summary_label') }}</p>
        </div>
    </section>

    <section class="container-max education-section" aria-labelledby="diplomas-heading">
        <x-education-heading
            heading-id="diplomas-heading"
            :eyebrow="__('courses.diplomas.eyebrow')"
            :title="__('courses.diplomas.title')"
            :accent="__('courses.diplomas.title_accent')"
            :aside="__('courses.diplomas.aside')" />

        @foreach (__('courses.diplomas.items') as $index => $item)
            @php($visual = $diplomaVisuals[$index])
            <x-education-card
                :icon="$visual['icon']"
                :marker="$visual['marker']"
                :title="$item['title']"
                :period="$item['period']"
                :modifier="$visual['modifier']">
                @foreach ($item['story'] as $paragraph)
                    <p>{!! $paragraph !!}</p>
                @endforeach

                <x-slot:details>
                    <dl class="education-card__facts">
                        <div>
                            <dt>{{ __('courses.labels.school') }}</dt>
                            <dd>{{ $item['details']['school'] }}</dd>
                        </div>
                        <div>
                            <dt>{{ __('courses.labels.level') }}</dt>
                            <dd>{{ $item['details']['level'] }}</dd>
                        </div>
                        <div>
                            <dt>{{ __('courses.labels.direction') }}</dt>
                            <dd>{{ $item['details']['direction'] }}</dd>
                        </div>
                    </dl>

                    <div class="education-card__completion">
                        <p class="education-card__label">{{ __('courses.labels.completion') }}</p>
                        <span class="education-card__completion-bar">
                            <x-themed-image :light="$visual['completion']" :dark="$visual['completion']" />
                        </span>
                    </div>

                    <p class="education-card__label">{{ __('courses.labels.achievements') }}</p>
                    <ul class="education-card__list">
                        @foreach ($item['achievements'] as $achievement)
                            <li>{{ $achievement }}</li>
                        @endforeach
                    </ul>
                </x-slot:details>
            </x-education-card>
        @endforeach
    </section>

    <section class="container-max education-section education-section--certificates" aria-labelledby="certificates-heading">
        <x-education-heading
            heading-id="certificates-heading"
            :eyebrow="__('courses.certificates.eyebrow')"
            :title="__('courses.certificates.title')"
            :accent="__('courses.certificates.title_accent')"
            :aside="__('courses.certificates.aside')" />

        @foreach (__('courses.certificates.items') as $index => $item)
            @php($visual = $certificateVisuals[$index])
            <x-education-card
                :icon="$visual['icon']"
                :marker="$visual['marker']"
                :marker-width="$visual['markerWidth']"
                :title="$item['title']"
                :period="$item['period']"
                :modifier="$visual['modifier']">
                @foreach ($item['story'] as $paragraph)
                    <p>{!! $paragraph !!}</p>
                @endforeach

                <x-slot:details>
                    <p class="education-card__label">{{ __('courses.labels.topics') }}</p>
                    <ul class="education-card__list">
                        @foreach ($item['topics'] as $topic)
                            <li>{{ $topic }}</li>
                        @endforeach
                    </ul>
                </x-slot:details>
            </x-education-card>
        @endforeach
    </section>
@endsection
