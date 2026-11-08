<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

        <title>{{ config('portfolio.name') }}</title>

        @fonts

        {{-- Applies the stored theme and accent colour before first paint to avoid a flash of the defaults. --}}
	<script nonce="{{ Vite::cspNonce() }}">
            (function () {
                try {
                    var stored = JSON.parse(localStorage.getItem('porto.preferences') || '{}');
                    var theme = stored.theme === 'light' || stored.theme === 'dark'
                        ? stored.theme
                        : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                    document.documentElement.dataset.theme = theme;

                    if (typeof stored.accent === 'string' && /^#[0-9a-f]{6}$/i.test(stored.accent)) {
                        document.documentElement.style.setProperty('--accent', stored.accent);
                    }
                } catch (error) {
                    document.documentElement.dataset.theme = 'light';
                }
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <canvas class="starfield" id="starfield" aria-hidden="true"></canvas>
        <a class="skip-link" href="#main">{{ __('site.common.skip_to_content') }}</a>

        <x-header />

        <main id="main">
            @yield('content')
        </main>

        <x-footer />
    </body>
</html>
