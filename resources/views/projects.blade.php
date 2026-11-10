@extends('layouts.app')

@section('content')
    <section class="container-max projects-intro" aria-labelledby="projects-title">
        <div class="projects-intro__text">
            <p class="projects-intro__eyebrow">{{ __('projects.overview.eyebrow') }}</p>
            <h1 class="projects-intro__title" id="projects-title">{{ __('projects.overview.title') }} <span>{{ __('projects.overview.title_accent') }}</span></h1>
            <p class="projects-intro__lead">{{ __('projects.overview.lead') }}</p>
        </div>
        <div class="projects-intro__count">
            <p class="projects-intro__count-value">{{ str_pad((string) $overview['total'], 2, '0', STR_PAD_LEFT) }}</p>
            <p class="projects-intro__count-label">{{ __('projects.overview.count_label') }}</p>
        </div>
    </section>

    <section class="container-max projects-list" aria-labelledby="projects-list-label">
        <div class="projects-list__label">
            <p id="projects-list-label">{{ __('projects.overview.list_label') }}</p>
            <p>{{ __('projects.overview.list_aside') }}</p>
        </div>

        <x-project-filters :options="$filterOptions" :filters="$filters" />

        <div class="projects-list__cards" data-project-results>
            @forelse ($overview['projects'] as $project)
                <x-project-card :project="$project" :total="$overview['total']" :details-first="$loop->even" />
            @empty
                <p class="projects-empty">{{ __('projects.overview.empty') }}</p>
            @endforelse
        </div>
    </section>
@endsection
