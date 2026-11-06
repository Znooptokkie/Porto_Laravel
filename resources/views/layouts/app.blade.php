<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('portfolio.name') }}</title>

        @fonts

        {{-- Applies the stored theme before first paint to avoid a flash of the wrong theme. --}}
        <script>
            (function () {
                try {
                    var stored = JSON.parse(localStorage.getItem('porto.preferences') || '{}');
                    var theme = stored.theme === 'light' || stored.theme === 'dark'
                        ? stored.theme
                        : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                    document.documentElement.dataset.theme = theme;
                } catch (error) {
                    document.documentElement.dataset.theme = 'light';
                }
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <a class="skip-link" href="#main">{{ __('site.common.skip_to_content') }}</a>

        <x-header />

        <main id="main">
            @yield('content')
        </main>

        <x-footer />
    </body>
</html>
