<footer class="site-footer">
    <div class="container-max site-footer__inner">
        <a class="site-footer__link" href="{{ config('portfolio.links.github') }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('site.footer.github_label') }}">github.com/znooptokkie</a>
        <span>{{ now()->year }} {{ __('site.footer.rights') }} </span>
        <span class="site-footer__name">
            <x-themed-image :light="'images/brand/light/brandLogo.svg'" :dark="'images/brand/dark/BrandLogo.svg'" class="site-footer__logo" />
            {{ config('portfolio.name') }}
        </span>
    </div>
</footer>
