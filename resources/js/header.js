import {
    applyPreferences,
    normaliseHex,
    readPreferences,
    resolveTheme,
    savePreferences,
    setLocale,
    DEFAULT_ACCENT,
    TEXT_SCALE_MAX,
    TEXT_SCALE_MIN,
} from './preferences.js';

/**
 * Wires up the header controls: theme, language, and the preferences popover.
 * Settings are read from localStorage and applied on the root element.
 */
export function initHeader() {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    const preferences = readPreferences();
    applyPreferences(preferences);
    bindPopovers(header);
    bindMobileMenu(header);
    bindThemeToggle(header);
    bindLanguage(header, preferences);
    bindPreferences(header, preferences);
}

/** @param {HTMLElement} header */
function bindPopovers(header) {
    const triggers = header.querySelectorAll('[data-popover-trigger]');

    triggers.forEach((trigger) => {
        const popover = document.getElementById(trigger.getAttribute('aria-controls'));

        trigger.addEventListener('click', () => {
            const isOpen = trigger.getAttribute('aria-expanded') === 'true';
            closeAllPopovers(header);

            if (!isOpen) {
                openPopover(trigger, popover);
            }
        });
    });

    document.addEventListener('click', (event) => {
        if (!header.contains(event.target)) {
            closeAllPopovers(header);
        }
    });

    header.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        const openTrigger = header.querySelector('[aria-expanded="true"]');
        closeAllPopovers(header);
        openTrigger?.focus();
        setMobileMenu(header, false, { returnFocus: true });
    });
}

/**
 * The mobile menu is the same navigation block, shown as a panel below 834px.
 * It opens with the menu button and closes with the same button, Escape, or a click outside.
 *
 * @param {HTMLElement} header
 */
function bindMobileMenu(header) {
    const toggle = header.querySelector('[data-menu-toggle]');

    if (!toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isOpen = header.dataset.menuOpen === 'true';
        setMobileMenu(header, !isOpen, { returnFocus: isOpen });
    });

    header.querySelector('[data-menu-close]')?.addEventListener('click', () => {
        setMobileMenu(header, false, { returnFocus: true });
    });

    document.addEventListener('click', (event) => {
        if (header.dataset.menuOpen === 'true' && !header.contains(event.target)) {
            setMobileMenu(header, false);
        }
    });
}

/**
 * @param {HTMLElement} header
 * @param {boolean} isOpen
 * @param {{ returnFocus?: boolean }} [options]
 */
function setMobileMenu(header, isOpen, options = {}) {
    const toggle = header.querySelector('[data-menu-toggle]');
    const isCurrentlyOpen = header.dataset.menuOpen === 'true' && header.dataset.menuClosing !== 'true';

    if (!toggle || isCurrentlyOpen === isOpen) {
        return;
    }

    toggle.setAttribute('aria-expanded', String(isOpen));
    toggle.setAttribute('aria-label', toggle.dataset[isOpen ? 'labelClose' : 'labelOpen']);

    if (isOpen) {
        header.dataset.menuOpen = 'true';
        delete header.dataset.menuClosing;
        startMenuOpenAnimation(header);
        header.querySelector('.site-nav__link')?.focus();
        return;
    }

    closeAllPopovers(header);

    if (options.returnFocus) {
        toggle.focus();
    }

    // Keep the panel visible while the slide-up plays; finish immediately when animations are off.
    if (document.documentElement.dataset.motion === 'off') {
        finishMobileMenuClose(header);
        return;
    }

    header.dataset.menuClosing = 'true';
    const panel = header.querySelector('.site-nav');
    panel?.addEventListener('animationend', () => finishMobileMenuClose(header), { once: true });
    window.setTimeout(() => finishMobileMenuClose(header), 400);
}

/**
 * The slide-down runs once when the menu opens. Changing a visitor preference while the menu is
 * open must not replay it, so the animation flag is removed as soon as the slide has finished.
 *
 * @param {HTMLElement} header
 */
function startMenuOpenAnimation(header) {
    const panel = header.querySelector('.site-nav');
    header.dataset.menuAnimate = 'true';
    const finish = () => delete header.dataset.menuAnimate;
    panel?.addEventListener('animationend', finish, { once: true });
    window.setTimeout(finish, 400);
}

/**
 * @param {HTMLElement} header
 */
function finishMobileMenuClose(header) {
    header.dataset.menuOpen = 'false';
    delete header.dataset.menuClosing;
}

/**
 * @param {HTMLElement} trigger
 * @param {HTMLElement|null} popover
 */
function openPopover(trigger, popover) {
    if (!popover) {
        return;
    }

    trigger.setAttribute('aria-expanded', 'true');
    popover.hidden = false;
    popover.querySelector('button, input')?.focus();
}

/** @param {HTMLElement} header */
function closeAllPopovers(header) {
    header.querySelectorAll('[data-popover-trigger]').forEach((trigger) => {
        trigger.setAttribute('aria-expanded', 'false');
        document.getElementById(trigger.getAttribute('aria-controls'))?.setAttribute('hidden', '');
    });
}

/** @param {HTMLElement} header */
function bindThemeToggle(header) {
    const button = header.querySelector('[data-theme-toggle]');

    button?.addEventListener('click', () => {
        const nextTheme = resolveTheme() === 'dark' ? 'light' : 'dark';
        savePreferences({ theme: nextTheme });
        applyPreferences(readPreferences());
        button.setAttribute('aria-pressed', String(nextTheme === 'dark'));
    });
}

/**
 * @param {HTMLElement} header
 * @param {Record<string, unknown>} preferences
 */
function bindLanguage(header, preferences) {
    const current = preferences.locale === 'en' ? 'en' : 'nl';

    header.querySelectorAll('[data-locale-option]').forEach((option) => {
        option.setAttribute('aria-checked', String(option.dataset.localeOption === current));

        option.addEventListener('click', () => {
            const locale = option.dataset.localeOption === 'en' ? 'en' : 'nl';

            if (locale === current) {
                return;
            }

            setLocale(locale);
            window.location.reload();
        });
    });
}

/**
 * @param {HTMLElement} header
 * @param {Record<string, unknown>} preferences
 */
function bindPreferences(header, preferences) {
    bindAccent(header, preferences);
    bindToggle(header, '[data-motion-toggle]', 'motion', (value) => (value ? 'on' : 'off'), (state) => state === 'on');
    bindToggle(header, '[data-contrast-toggle]', 'contrast', (value) => (value ? 'high' : 'normal'), (state) => state === 'high');
    bindToggle(header, '[data-colorblind-toggle]', 'colorblind', (value) => value, (state) => Boolean(state));
    bindTextSize(header, preferences);
}

/**
 * @param {HTMLElement} header
 * @param {Record<string, unknown>} preferences
 */
function bindAccent(header, preferences) {
    const activeAccent = typeof preferences.accent === 'string' ? preferences.accent : DEFAULT_ACCENT;
    const swatches = header.querySelectorAll('[data-accent-swatch]');
    const hexInput = header.querySelector('[data-accent-hex]');
    const hexError = header.querySelector('[data-accent-hex-error]');

    const markActive = (hex) => {
        swatches.forEach((swatch) => {
            swatch.setAttribute('aria-checked', String(swatch.dataset.accentSwatch.toUpperCase() === hex));
        });
    };

    const applyAccent = (hex) => {
        savePreferences({ accent: hex });
        applyPreferences(readPreferences());
        markActive(hex);
    };

    markActive(activeAccent.toUpperCase());

    swatches.forEach((swatch) => {
        swatch.addEventListener('click', () => {
            const hex = normaliseHex(swatch.dataset.accentSwatch);
            hexError.hidden = true;
            hexInput.removeAttribute('aria-invalid');
            applyAccent(hex);
        });
    });

    hexInput?.addEventListener('change', () => {
        const hex = normaliseHex(hexInput.value);

        if (!hex) {
            hexInput.setAttribute('aria-invalid', 'true');
            hexError.hidden = false;

            return;
        }

        hexInput.removeAttribute('aria-invalid');
        hexError.hidden = true;
        hexInput.value = hex;
        applyAccent(hex);
    });
}

/**
 * @param {HTMLElement} header
 * @param {string} selector
 * @param {'motion'|'contrast'|'colorblind'} key
 * @param {(value: boolean) => unknown} toStored
 * @param {(stored: unknown) => boolean} fromStored
 */
function bindToggle(header, selector, key, toStored, fromStored) {
    const button = header.querySelector(selector);

    if (!button) {
        return;
    }

    const isActive = fromStored(readPreferences()[key] ?? (key === 'motion' ? document.documentElement.dataset.motion : defaults()[key]));
    button.setAttribute('aria-pressed', String(isActive));

    button.addEventListener('click', () => {
        const nextActive = button.getAttribute('aria-pressed') !== 'true';
        button.setAttribute('aria-pressed', String(nextActive));
        savePreferences({ [key]: toStored(nextActive) });
        applyPreferences(readPreferences());
    });
}

/**
 * @param {HTMLElement} header
 * @param {Record<string, unknown>} preferences
 */
function bindTextSize(header, preferences) {
    const slider = header.querySelector('[data-text-size]');

    if (!slider) {
        return;
    }

    slider.min = String(TEXT_SCALE_MIN);
    slider.max = String(TEXT_SCALE_MAX);
    slider.value = String(typeof preferences.textScale === 'number' ? preferences.textScale : TEXT_SCALE_MIN);

    slider.addEventListener('input', () => {
        savePreferences({ textScale: Number(slider.value) });
        applyPreferences(readPreferences());
    });
}

function defaults() {
    return { motion: 'on', contrast: 'normal', colorblind: false };
}
