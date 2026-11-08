import { mixHex, pickInk } from './accent-contrast.js';

const STORAGE_KEY = 'porto.preferences';
const DEFAULT_ACCENT = '#2ecc71';
const TEXT_SCALE_MIN = 100;
const TEXT_SCALE_MAX = 125;
/* Must match the share used for --accent-soft in resources/css/app.css. */
const ACCENT_SOFT_SHARE = 0.15;
const FALLBACK_SURFACE = '#FFFFFF';

/**
 * @typedef {Object} Preferences
 * @property {'light'|'dark'} [theme] Unset until the visitor chooses; the system preference is used until then.
 * @property {'nl'|'en'} locale
 * @property {string} accent Hex colour such as #2ECC71.
 * @property {'on'|'off'} motion
 * @property {'normal'|'high'} contrast
 * @property {boolean} colorblind
 * @property {number} textScale Percentage between 100 and 125.
 */

/** @returns {Preferences} */
function defaults() {
    return {
        locale: 'nl',
        accent: DEFAULT_ACCENT,
        motion: 'on',
        contrast: 'normal',
        colorblind: false,
        textScale: TEXT_SCALE_MIN,
    };
}

/** @returns {Partial<Preferences>} */
export function readPreferences() {
    try {
        return JSON.parse(localStorage.getItem(STORAGE_KEY) ?? '{}');
    } catch {
        return {};
    }
}

/** @param {Partial<Preferences>} changes */
export function savePreferences(changes) {
    const next = { ...readPreferences(), ...changes };
    localStorage.setItem(STORAGE_KEY, JSON.stringify(next));
    return next;
}

/** @returns {'light'|'dark'} */
export function resolveTheme() {
    const stored = readPreferences().theme;

    if (stored === 'light' || stored === 'dark') {
        return stored;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

/**
 * Normalises a user-entered hex colour to #RRGGBB, or returns null when invalid.
 *
 * @param {string} value
 * @returns {string|null}
 */
export function normaliseHex(value) {
    const match = /^#?([0-9a-f]{3}|[0-9a-f]{6})$/i.exec(value.trim());

    if (!match) {
        return null;
    }

    const digits = match[1].length === 3
        ? match[1].split('').map((character) => character + character).join('')
        : match[1];

    return `#${digits.toUpperCase()}`;
}

/**
 * Applies the stored preferences to the document. Safe to call repeatedly.
 *
 * @param {Partial<Preferences>} preferences
 */
export function applyPreferences(preferences) {
    const root = document.documentElement;
    const merged = { ...defaults(), ...preferences };

    if (preferences.motion === undefined && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        merged.motion = 'off';
    }

    root.dataset.theme = resolveTheme();
    root.dataset.motion = merged.motion;
    root.dataset.contrast = merged.contrast;
    root.dataset.colorblind = merged.colorblind ? 'on' : 'off';
    root.style.setProperty('--text-scale', String(merged.textScale / 100));
    root.style.setProperty('--accent', merged.accent);
    applyAccentInks(root, merged.accent);
}

/**
 * Sets the text colour used on accent backgrounds (--accent-ink) and on the accent tint (--accent-ink-soft).
 * Both are chosen for WCAG contrast against the colour they sit on. The tint depends on the active theme's surface.
 *
 * @param {HTMLElement} root
 * @param {string} accent
 */
function applyAccentInks(root, accent) {
    const surface = getComputedStyle(root).getPropertyValue('--color-surface').trim();
    const surfaceHex = /^#[0-9a-f]{6}$/i.test(surface) ? surface : FALLBACK_SURFACE;
    const accentSoft = mixHex(accent, surfaceHex, ACCENT_SOFT_SHARE);

    root.style.setProperty('--accent-ink', pickInk(accent));
    root.style.setProperty('--accent-ink-soft', pickInk(accentSoft));
}

/**
 * Stores the locale in localStorage and mirrors it in a cookie so Laravel can render it.
 *
 * @param {'nl'|'en'} locale
 */
export function setLocale(locale) {
    savePreferences({ locale });
    document.cookie = `locale=${locale}; path=/; max-age=31536000; SameSite=Lax`;
}

export { DEFAULT_ACCENT, TEXT_SCALE_MAX, TEXT_SCALE_MIN };
