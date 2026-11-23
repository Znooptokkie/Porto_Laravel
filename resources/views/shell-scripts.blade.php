@extends('layouts.app')

@section('content')
    <section class="container-max projects-intro" aria-labelledby="shell-scripts-title">
        <div class="projects-intro__text">
            <p class="projects-intro__eyebrow">{{ __('shell-scripts.overview.eyebrow') }}</p>
            <h1 class="projects-intro__title" id="shell-scripts-title">{{ __('shell-scripts.overview.title') }} <span>{{ __('shell-scripts.overview.title_accent') }}</span></h1>
            <p class="projects-intro__lead">{{ __('shell-scripts.overview.lead') }}</p>
        </div>
        <div class="projects-intro__count">
            <p class="projects-intro__count-value">{{ str_pad((string) $totalCount, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="projects-intro__count-label">{{ __('shell-scripts.overview.count_label') }}</p>
        </div>
    </section>

    <section class="container-max projects-list shell-scripts-list" aria-labelledby="shell-scripts-list-label">
        <div class="projects-list__label">
            <p id="shell-scripts-list-label">{{ __('shell-scripts.overview.list_label') }}</p>
            <p>{{ __('shell-scripts.overview.list_aside') }}</p>
        </div>

        <form method="GET" action="{{ route('shell-scripts') }}" class="project-filters" role="search">
            <x-search-field :label="__('shell-scripts.filters.search')" :value="$search" />

            <a class="project-filters__reset" href="{{ route('shell-scripts') }}" aria-label="{{ __('shell-scripts.filters.reset') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                    <path d="M21 3v5h-5"/>
                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                    <path d="M3 21v-5h5"/>
                </svg>
            </a>
        </form>

        <x-results-count :count="$scripts->count()" translation-key="shell-scripts.overview.found" :hidden="$search === ''" />

        <div class="projects-list__cards" data-code-entries>
            <x-code-copy-popover />
            @forelse ($scripts as $script)
                <x-code-entry-card :heading="$script->localizedTitle() ?? $script->name" :heading-id="'shell-script-'.$script->id.'-title'" :description="$script->localizedDescription()" :package="$script->package" :install-command="$script->install_command" :install-command-debian="$script->install_command_debian" :code="$script->code" language="bash" />
            @empty
                <p class="projects-empty">{{ $search !== '' ? __('shell-scripts.overview.no_results') : __('shell-scripts.overview.empty') }}</p>
            @endforelse
        </div>
    </section>
@endsection
