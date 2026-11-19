@extends('layouts.app')

@section('content')
    <section class="container-max projects-intro" aria-labelledby="linux-commands-title">
        <div class="projects-intro__text">
            <p class="projects-intro__eyebrow">{{ __('linux-commands.overview.eyebrow') }}</p>
            <h1 class="projects-intro__title" id="linux-commands-title">{{ __('linux-commands.overview.title') }} <span>{{ __('linux-commands.overview.title_accent') }}</span></h1>
            <p class="projects-intro__lead">{{ __('linux-commands.overview.lead') }}</p>
        </div>
        <div class="projects-intro__count">
            <p class="projects-intro__count-value">{{ str_pad((string) $commandCount, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="projects-intro__count-label">{{ __('linux-commands.overview.count_label') }}</p>
        </div>
    </section>

    <section class="container-max projects-list linux-commands-list" aria-labelledby="linux-commands-list-label">
        <div class="projects-list__label">
            <p id="linux-commands-list-label">{{ __('linux-commands.overview.list_label') }}</p>
            <p>{{ __('linux-commands.overview.list_aside') }}</p>
        </div>

        <x-keyword-filter :keywords="$keywords" :selected="$selectedKeyword" :label="__('linux-commands.filters.keywords')" />

        <form method="GET" action="{{ route('linux-commands') }}" class="project-filters" role="search">
            <x-search-field :label="__('linux-commands.filters.search')" :value="$search" />

            @if ($selectedKeyword)
                <input type="hidden" name="keyword" value="{{ $selectedKeyword->value }}">
            @endif

            <a class="project-filters__reset" href="{{ route('linux-commands') }}" aria-label="{{ __('linux-commands.filters.reset') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                    <path d="M21 3v5h-5"/>
                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                    <path d="M3 21v-5h5"/>
                </svg>
            </a>
        </form>

        <div class="projects-list__cards" data-code-entries>
            <x-code-copy-popover />
            @forelse ($categories as $category => $cards)
                <div class="code-entries__category">
                    @if ($category !== '')
                        <p class="code-entries__category-label">{{ $category }}</p>
                    @endif

                    @foreach ($cards as $entries)
                        @php
                            $heading = collect([$category, $entries->first()->localizedCardTitle()])->filter()->implode(' - ') ?: null;
                        @endphp
                        <x-code-entry-group :heading="$heading" :heading-id="$heading ? 'linux-command-card-'.$loop->parent->index.'-'.$loop->index : null" :entries="$entries" />
                    @endforeach
                </div>
            @empty
                <p class="projects-empty">{{ $search !== '' ? __('linux-commands.overview.no_results') : __('linux-commands.overview.empty') }}</p>
            @endforelse
        </div>
    </section>
@endsection
