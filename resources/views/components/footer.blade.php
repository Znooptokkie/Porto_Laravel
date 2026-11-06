<footer class="site-footer">
    <div class="container-max site-footer__inner">
        <a class="site-footer__link" href="{{ config('portfolio.links.github') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('site.footer.github_label') }}">github.com/znooptokkie</a>
        <span>{{ __('site.footer.rights') }}</span>
        <span>{{ now()->year }} {{ config('portfolio.name') }}</span>
    </div>
</footer>
