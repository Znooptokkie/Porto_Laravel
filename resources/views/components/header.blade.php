<header class="site-header" data-site-header>
    <div class="site-header__bar">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand__logo-set brand__logo-set--desktop">
                <x-themed-image :light="'images/figma/light/brandLogo.svg'" :dark="'images/figma/dark/BrandLogo.svg'" class="brand__logo" />
            </span>
            <span class="brand__logo-set brand__logo-set--mobile">
                <x-themed-image :light="'images/figma/mobile/light/navMenuBrand.svg'" :dark="'images/figma/mobile/dark/navMenuBrand.svg'" class="brand__logo" />
            </span>
            <span class="brand__name">{{ config('portfolio.name') }}</span>
        </a>

        <button type="button" class="menu-toggle" data-menu-toggle aria-expanded="false" aria-controls="site-menu" aria-label="{{ __('site.menu.open') }}" data-label-open="{{ __('site.menu.open') }}" data-label-close="{{ __('site.menu.close') }}">
            <x-themed-image :light="'images/figma/mobile/light/menuButton.svg'" :dark="'images/figma/mobile/dark/menuButton.svg'" />
        </button>

        <div class="site-nav" id="site-menu">
            <a class="site-nav__brand" href="{{ route('home') }}">
                <x-themed-image :light="'images/figma/mobile/light/navMenuBrand.svg'" :dark="'images/figma/mobile/dark/navMenuBrand.svg'" class="site-nav__brand-logo" />
                <span class="site-nav__brand-name">{{ config('portfolio.name') }}</span>
            </a>

            <nav aria-label="{{ __('site.nav.label') }}">
                <ul class="site-nav__links">
                    <li><a class="site-nav__link{{ request()->routeIs('courses') ? ' site-nav__link--menu-active' : '' }}" href="{{ route('courses') }}" @if (request()->routeIs('courses')) aria-current="page" @endif>{{ __('site.nav.courses') }}</a></li>
                    <li><a class="site-nav__link{{ request()->routeIs('projects*') ? ' site-nav__link--menu-active' : '' }}" href="{{ route('projects') }}" @if (request()->routeIs('projects*')) aria-current="page" @endif>{{ __('site.nav.projects') }}</a></li>
                    <li><a class="site-nav__link" href="#">{{ __('site.nav.about') }}</a></li>
                    <li><a class="site-nav__link" href="#">{{ __('site.nav.leetcode') }}</a></li>
                </ul>
            </nav>

            <span class="site-nav__divider" aria-hidden="true"></span>

            <div class="site-nav__controls">
                <button type="button" class="icon-button" data-theme-toggle aria-label="{{ __('site.controls.theme') }}" aria-pressed="false">
                    <x-themed-image :light="'images/figma/light/sunIcon.svg'" :dark="'images/figma/dark/MoonIcon.svg'" />
                </button>

                <div class="popover-anchor">
                    <button type="button" class="icon-button" data-popover-trigger aria-controls="language-popover" aria-expanded="false" aria-label="{{ __('site.controls.language') }}">
                        <x-themed-image :light="'images/figma/light/languageIcon.png'" :dark="'images/figma/dark/LanguageIcon.png'" accent />
                    </button>

                    <div id="language-popover" class="popover" role="group" aria-labelledby="language-popover-title" hidden>
                        <p class="popover__title" id="language-popover-title">{{ __('site.language.title') }}</p>
                        <ul class="popover__options" role="radiogroup" aria-labelledby="language-popover-title">
                            <li>
                                <button type="button" class="popover__option" role="radio" data-locale-option="nl" aria-checked="{{ app()->getLocale() === 'nl' ? 'true' : 'false' }}">
                                    <span class="popover__dot" aria-hidden="true"></span>{{ __('site.language.nl') }}
                                </button>
                            </li>
                            <li>
                                <button type="button" class="popover__option" role="radio" data-locale-option="en" aria-checked="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}">
                                    <span class="popover__dot" aria-hidden="true"></span>{{ __('site.language.en') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="popover-anchor">
                    <button type="button" class="icon-button" data-popover-trigger aria-controls="preferences-popover" aria-expanded="false" aria-label="{{ __('site.controls.preferences') }}">
                        <x-themed-image :light="'images/figma/light/editIcon.svg'" :dark="'images/figma/dark/EditIcon.svg'" />
                    </button>

                    <div id="preferences-popover" class="popover popover--preferences" role="group" aria-labelledby="preferences-popover-title" hidden>
                        <p class="popover__title" id="preferences-popover-title">{{ __('site.preferences.accent_title') }}</p>

                        <div class="swatches" role="radiogroup" aria-label="{{ __('site.preferences.accent_title') }}">
                            @foreach (config('portfolio.accent_presets') as $preset)
                                <button type="button" class="swatch" role="radio"
                                    data-accent-swatch="{{ $preset['hex'] }}"
                                    aria-checked="false"
                                    aria-label="{{ __('site.preferences.accent_names.'.$preset['key']) }} {{ $preset['hex'] }}"
                                    style="--swatch: {{ $preset['hex'] }}"></button>
                            @endforeach
                        </div>

                        <div class="hex-field">
                            <label for="accent-hex">{{ __('site.preferences.hex_label') }}</label>
                            <input id="accent-hex" type="text" inputmode="text" autocomplete="off" maxlength="7"
                                placeholder="{{ __('site.preferences.hex_placeholder') }}"
                                aria-describedby="accent-hex-error" data-accent-hex>
                        </div>
                        <p class="hex-field__error" id="accent-hex-error" data-accent-hex-error hidden>{{ __('site.preferences.hex_invalid') }}</p>

                        <p class="popover__title">{{ __('site.preferences.special_title') }}</p>
                        <div class="toggle-row">
                            <button type="button" class="toggle-button" data-colorblind-toggle aria-pressed="false" aria-label="{{ __('site.preferences.colorblind') }}">
                                <x-themed-image :light="'images/figma/dark/pop-visibilityIcon.png'" :dark="'images/figma/dark/pop-visibilityIcon.png'" accent />
                            </button>
                            <button type="button" class="toggle-button" data-motion-toggle aria-pressed="true" aria-label="{{ __('site.preferences.motion') }}">
                                <x-themed-image :light="'images/figma/dark/pop-motionPreferenceIcon.png'" :dark="'images/figma/dark/pop-motionPreferenceIcon.png'" accent />
                            </button>
                            <button type="button" class="toggle-button" data-contrast-toggle aria-pressed="false" aria-label="{{ __('site.preferences.contrast') }}">
                                <x-themed-image :light="'images/figma/dark/pop-contrastPreferenceIcon.png'" :dark="'images/figma/dark/pop-contrastPreferenceIcon.png'" accent />
                            </button>
                        </div>

                        <div class="text-size">
                            <x-themed-image :light="'images/figma/dark/pop-textSizeIcon.png'" :dark="'images/figma/dark/pop-textSizeIcon.png'" accent />
                            <label class="visually-hidden" for="text-size">{{ __('site.preferences.text_size_label') }}</label>
                            <input id="text-size" type="range" min="100" max="125" step="5" value="100" data-text-size>
                        </div>
                    </div>
                </div>
            </div>
            <span class="site-nav__rule site-nav__rule--1" aria-hidden="true">
                <x-themed-image :light="'images/figma/mobile/light/navDivider'.(request()->routeIs('courses') ? '02' : '01').'.svg'" :dark="'images/figma/dark/pop-navDivider'.(request()->routeIs('courses') ? '02' : '01').'.svg'" />
            </span>
            <span class="site-nav__rule site-nav__rule--2" aria-hidden="true">
                <x-themed-image :light="'images/figma/mobile/light/navDivider01.svg'" :dark="'images/figma/dark/pop-navDivider01.svg'" />
            </span>
            <span class="site-nav__rule site-nav__rule--3" aria-hidden="true">
                <x-themed-image :light="'images/figma/mobile/light/navDivider01.svg'" :dark="'images/figma/dark/pop-navDivider01.svg'" />
            </span>
            <span class="site-nav__rule site-nav__rule--4" aria-hidden="true">
                <x-themed-image :light="'images/figma/mobile/light/navDivider01.svg'" :dark="'images/figma/dark/pop-navDivider01.svg'" />
            </span>
            <button type="button" class="site-nav__close" data-menu-close aria-label="{{ __('site.menu.close') }}">
                <span class="site-nav__accent-bar" aria-hidden="true"></span>
                <span class="site-nav__chevron" aria-hidden="true">
                <x-themed-image :light="'images/figma/mobile/light/navChevron.svg'" :dark="'images/figma/dark/pop-navChevron.svg'" />
                </span>
            </button>
        </div>
    </div>
</header>
