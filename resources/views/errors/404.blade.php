@php(app()->setLocale(request()->cookie('locale') === 'en' ? 'en' : 'nl'))
@extends('layouts.app')

@section('body-class', 'body--fill')

@section('content')
    <section class="container-max not-found" aria-labelledby="not-found-title">
        <div class="not-found__heading">
            <p class="not-found__eyebrow">{{ __('site.not_found.eyebrow') }}</p>
            <h1 class="not-found__title" id="not-found-title">{{ __('site.not_found.title') }} <span>{{ __('site.not_found.title_accent') }}</span></h1>
        </div>
        <p class="not-found__lead">{{ __('site.not_found.lead') }}</p>
        <div class="not-found__actions">
            <a class="button button--primary" href="{{ route('home') }}">{{ __('site.not_found.home') }}</a>
            <a class="button" href="{{ \App\Http\Middleware\SetPageLocale::url('projects') }}">{{ __('site.not_found.projects') }}</a>
        </div>
    </section>
@endsection
