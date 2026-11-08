@extends('layouts.app')

@section('content')
    <div class="container-max">
    <section class="hero" aria-labelledby="hero-title">
            <div class="hero__text">
                <p class="greeting">{{ __('home.hero.greeting') }}</p>
                <h1 class="hero__name" id="hero-title">
                    {{ __('home.hero.first_name') }} <span class="hero__name-accent">{{ __('home.hero.last_name') }}</span>
                </h1>
                <div class="role-row">
                    <p class="role-row__role">{{ __('home.hero.role') }}</p>
                    <span class="role-row__divider" aria-hidden="true"></span>
                    <span class="social-links">
                        <a class="social-link" href="{{ config('portfolio.links.linkedin') }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <x-themed-image :light="'images/figma/light/linkedinIcon.svg'" :dark="'images/figma/dark/LinkedInIcon.svg'" />
                        </a>
                        @if (config('portfolio.links.email'))
                            <a class="social-link" href="mailto:{{ config('portfolio.links.email') }}" aria-label="{{ __('home.hero.email_label') }}">
                                <x-themed-image :light="'images/figma/light/emailIcon.svg'" :dark="'images/figma/dark/EmailIcon.svg'" />
                            </a>
                        @else
                            <span class="social-link" aria-hidden="true">
                                <x-themed-image :light="'images/figma/light/emailIcon.svg'" :dark="'images/figma/dark/EmailIcon.svg'" />
                            </span>
                        @endif
                        <a class="social-link" href="{{ config('portfolio.links.github') }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                            <x-themed-image :light="'images/figma/light/githubIcon.svg'" :dark="'images/figma/dark/GitHubIcon.svg'" />
                        </a>
                    </span>
                </div>
                <p class="intro-text">{!! __('home.hero.intro') !!}</p>
                <div class="hero__actions">
                    <a class="button button--primary" href="#">
                        {{ __('home.hero.projects') }}
                        <x-themed-image :light="'images/figma/light/externalLinkIcon.svg'" :dark="'images/figma/dark/ExternalLinkIcon.svg'" />
                    </a>
                    <a class="button" href="#">
                        {{ __('home.hero.about') }}
                        <x-themed-image :light="'images/figma/light/downArrowIcon.svg'" :dark="'images/figma/dark/DownArrowIcon.svg'" />
                    </a>
                </div>
            </div>

            <div class="portrait">
                <div class="portrait__orbit" aria-hidden="true">
                    <x-themed-image :light="'images/figma/light/orbit.svg'" :dark="'images/figma/dark/Orbit.svg'" />
                    <span class="portrait__tick-ring" style="--angle: 0deg"><span class="portrait__tick portrait__tick--accent"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 30deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 60deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 90deg"><span class="portrait__tick portrait__tick--accent"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 120deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 150deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 180deg"><span class="portrait__tick portrait__tick--accent"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 210deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 240deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 270deg"><span class="portrait__tick portrait__tick--accent"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 300deg"><span class="portrait__tick"></span></span>
                    <span class="portrait__tick-ring" style="--angle: 330deg"><span class="portrait__tick"></span></span>
                </div>
                <div class="portrait__frame">
                    <img src="{{ asset('images/profile/me_HH.webp') }}" alt="{{ __('home.hero.portrait_alt') }}" width="224" height="224">
                </div>
            </div>
        </section>

            <div class="hero__stats">
                @foreach (__('home.hero.stats') as $statKey => $stat)
                    <div class="hero-stat">
                        <p class="hero-stat__value">{{ $stat['value'] }}</p>
                        <p class="hero-stat__label {{ in_array($statKey, ['projects', 'leetcode'], true) ? 'hero-stat__label--compact' : '' }}">{!! $stat['label'] !!}</p>
                    </div>
                @endforeach
            </div>
    </div>

    <div class="container-max">
        <section class="section section--skills" aria-labelledby="skills-title">
            <x-section-heading
                :eyebrow="__('home.skills.eyebrow')"
                :title="__('home.skills.heading')"
                :accent="__('home.skills.heading_accent')" />

            <div class="skills">
                <blockquote class="skills__quote">
                    <p class="skills__quote-mark" aria-hidden="true">“</p>
                    <p class="skills__quote-text">{!! __('home.skills.quote') !!}</p>
                </blockquote>

                <div class="skills__grid">
                    @foreach ($skills as $skill)
                        <x-skill-card :skill="$skill" />
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section section--timeline" aria-labelledby="timeline-title">
            <x-section-heading
                :eyebrow="__('home.timeline.eyebrow')"
                :title="__('home.timeline.heading')"
                :accent="__('home.timeline.heading_accent')"
                :aside="__('home.timeline.subtitle')" />

            <ol class="timeline" aria-labelledby="timeline-title">
                @foreach (__('home.timeline.chapters') as $index => $chapter)
                    <x-timeline-chapter
                        :number="str_pad($index + 1, 2, '0', STR_PAD_LEFT)"
                        :chapter="$chapter"
                        :milestone="$index === 0
                            ? ['light' => 'images/figma/light/milestone.svg', 'dark' => 'images/figma/dark/Milestone.svg']
                            : ['light' => 'images/figma/light/milestone1.svg', 'dark' => 'images/figma/dark/Milestone.svg']"
                        :progress="['light' => 'images/figma/light/progressIndicator'.($index === 0 ? '' : $index).'.svg', 'dark' => 'images/figma/dark/ProgressIndicator'.($index === 0 ? '' : $index).'.svg']"
                        :icon="[
                            'light' => 'images/figma/light/'.['bookIcon', 'paintbrushIcon', 'codeIcon', 'workIcon', 'externalLinkIcon1'][$index].'.svg',
                            'dark' => 'images/figma/dark/'.['BookIcon', 'PaintbrushIcon', 'CodeIcon', 'WorkIcon', 'ExternalLinkIcon1'][$index].'.svg',
                        ]" />
                @endforeach
            </ol>
        </section>
    </div>
@endsection
