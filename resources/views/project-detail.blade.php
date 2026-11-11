@extends('layouts.app')

@section('content')
    @php
        $titleLead = $project->titleLead();
        $componentGroups = $project->componentGroups();
    @endphp

    <article class="container-max project-detail" aria-labelledby="project-detail-title">
        <header class="project-detail__intro">
            <nav aria-label="{{ __('projects.detail.breadcrumb') }}">
                <p class="project-detail__breadcrumb">
                    <a href="{{ route('projects') }}">
                        <x-themed-image class="project-icon project-detail__breadcrumb-icon" :light="'images/projects/icons/imgIcon.svg'" :dark="'images/projects/icons/imgIcon.svg'" />
                        {{ __('projects.detail.breadcrumb') }}
                    </a>
                    <span aria-hidden="true">|</span>
                    <span aria-current="page">{{ $project->translated('title') }}</span>
                </p>
            </nav>

            <div class="project-detail__header">
                <div class="project-detail__heading">
                    <p class="project-detail__eyebrow">{{ $project->intro_label ? $project->translated('intro_label') : $project->translated('category') }}</p>
                    <h1 class="project-detail__title" id="project-detail-title">
                        {{ $titleLead }}@if ($project->title_accent !== null && $titleLead !== $project->translated('title'))<span>{{ $project->title_accent }}</span>@endif
                    </h1>
                    <x-project-status :status="$project->status" />
                    <p class="project-detail__lead">{{ $project->subtitle ? $project->translated('subtitle') : $project->accented('summary') }}</p>
                </div>

                <div class="project-detail__context">
                    @if ($project->organization)
                        <p>{{ $project->translated('organization') }}</p>
                    @endif
                    @if ($project->department)
                        <p>{{ $project->translated('department') }}</p>
                    @endif
                    @if ($project->repository_url)
                        <a class="project-detail__repository" href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer">
                            <x-themed-image class="project-icon project-detail__repository-icon" :light="'images/projects/icons/imgGitHubIcon.svg'" :dark="'images/projects/icons/imgGitHubIcon.svg'" />
                            {{ $project->repository_url }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="project-detail__meta">
                @if ($project->detailTechnologies->isNotEmpty())
                    <ul class="project-tags" aria-label="{{ __('projects.detail.technologies') }}">
                        @foreach ($project->detailTechnologies as $technology)
                            <li class="project-tag">{{ $technology->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </header>

        <x-project-media :project="$project" />

        @if ($project->chapters->isNotEmpty())
            <section class="project-section" aria-labelledby="project-story-title">
                <p class="project-section__label">{{ __('projects.detail.story_label') }}</p>
                <div class="project-section__head">
                    <h2 class="project-section__title" id="project-story-title">
                        {{ $project->translated('story_heading') }}
                        @if ($project->story_heading_accent)
                            <span>{{ $project->translated('story_heading_accent') }}</span>
                        @endif
                    </h2>
                    @if ($project->story_aside)
                        <p class="project-section__aside">{{ $project->translated('story_aside') }}</p>
                    @endif
                </div>

                <ol class="project-chapters">
                    @foreach ($project->chapters as $chapter)
                        <x-project-chapter :chapter="$chapter" :number="$loop->iteration" :project-title="$project->translated('title')" />
                    @endforeach
                </ol>
            </section>
        @endif

        @if ($componentGroups->isNotEmpty())
            <section class="project-section" aria-labelledby="project-specifications-title">
                <p class="project-section__label">{{ __('projects.detail.specifications_label') }}</p>
                <div class="project-section__head">
                    <h2 class="project-section__title" id="project-specifications-title">
                        {{ __('projects.detail.specifications_title') }} <span>{{ __('projects.detail.specifications_accent') }}</span>
                    </h2>
                </div>

                <div class="project-specs">
                    @foreach (\App\Enums\ProjectComponentGroup::cases() as $group)
                        @continue(! $componentGroups->has($group->value))
                        <section class="project-specs__group" aria-labelledby="spec-{{ $group->value }}">
                            <h3 class="project-specs__heading" id="spec-{{ $group->value }}">
                                @if ($icon = $group->icon())
                                    <span class="icon-tile">
                                        <x-themed-image :light="$icon['light']" :dark="$icon['dark']" />
                                    </span>
                                @endif
                                {{ $group->label() }}
                            </h3>
                            <ul class="project-specs__list">
                                @foreach ($componentGroups[$group->value] as $component)
                                    <li>{{ $component->name }}</li>
                                @endforeach
                            </ul>
                        </section>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($project->contributors->isNotEmpty())
            <section class="project-section" aria-labelledby="project-contributors-title">
                <p class="project-section__label">{{ __('projects.detail.contributors_label') }}</p>
                <div class="project-section__head">
                    <h2 class="project-section__title" id="project-contributors-title">
                        {{ __('projects.detail.contributors_title') }} <span>{{ __('projects.detail.contributors_accent') }}</span>
                    </h2>
                </div>

                <ul class="project-contributors">
                    @foreach ($project->contributors as $contributor)
                        <li class="project-contributor">
                            <p class="project-contributor__name">
                                @if ($contributor->url)
                                    <a href="{{ $contributor->url }}" target="_blank" rel="noopener noreferrer">{{ $contributor->name }}</a>
                                @else
                                    {{ $contributor->name }}
                                @endif
                            </p>
                            <p class="project-contributor__role">{{ $contributor->pivot->role }}</p>
                            <a class="project-contributor__github" href="{{ $contributor->url ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('projects.detail.github_profile', ['name' => $contributor->name]) }}">
                                <span class="project-contributor__url">{{ $contributor->url }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <div class="project-detail__cta">
            <p class="project-detail__cta-title">{{ __('projects.detail.cta') }}</p>
            <a class="project-detail__back" href="{{ route('projects') }}">
                {{ __('projects.detail.all_projects') }}
                <x-themed-image class="project-icon project-detail__back-icon" :light="'images/projects/icons/imgOpenProjectButton1.svg'" :dark="'images/projects/icons/imgOpenProjectButton1.svg'" />
            </a>
        </div>
    </article>
@endsection
