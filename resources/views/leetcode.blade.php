@extends('layouts.app')

@section('content')
    <section class="container-max projects-intro" aria-labelledby="leetcode-title">
        <div class="projects-intro__text">
            <p class="projects-intro__eyebrow">{{ __('leetcode.overview.eyebrow') }}</p>
            <h1 class="projects-intro__title" id="leetcode-title">{{ __('leetcode.overview.title') }} <span>{{ __('leetcode.overview.title_accent') }}</span></h1>
            <p class="projects-intro__lead">{{ __('leetcode.overview.lead') }}</p>
        </div>
        <div class="projects-intro__count">
            <p class="projects-intro__count-value">{{ __('leetcode.overview.count_value') }}</p>
            <p class="projects-intro__count-label">{{ __('leetcode.overview.count_label') }}</p>
        </div>
    </section>

    <section class="container-max projects-list leetcode-list" aria-labelledby="leetcode-list-label" data-leetcode-list>
        <div class="projects-list__label">
            <p id="leetcode-list-label">{{ __('leetcode.overview.list_label') }}</p>
            <p>{{ __('leetcode.overview.list_aside') }}</p>
        </div>

        @php
            $hasActiveFilter = collect($filters)->except('page')->contains(fn (mixed $value): bool => filled($value));
        @endphp
        <x-leetcode-filters :filters="$filters" />

        <x-results-count :count="$overview['count']" translation-key="leetcode.overview.found" :hidden="! $hasActiveFilter" />

        <div class="leetcode-list__problems" data-project-results>
            @forelse ($overview['groups'] as $group)
                <x-leetcode-problem-group :group="$group" :position="$overview['offset'] + $loop->iteration" />
            @empty
                <p class="projects-empty">{{ __('leetcode.overview.empty') }}</p>
            @endforelse
        </div>

        @if ($overview['hasMorePages'])
            <div class="leetcode-list__more" data-leetcode-more data-next-page-url="{{ request()->fullUrlWithQuery(['page' => $overview['page'] + 1]) }}" role="status">
                <span class="leetcode-list__spinner" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('leetcode.overview.loading') }}</span>
            </div>
        @endif
    </section>
@endsection
