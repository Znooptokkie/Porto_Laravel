/**
 * Contrast helpers for the accent colour. Pure functions (no DOM access) so they can be tested in Node.
 *
 * Text on an accent background uses whichever of the two inks has the higher WCAG contrast ratio.
 */

export const INK_DARK = '#102334';
export const INK_LIGHT = '#FFFFFF';
export const WCAG_AA_TEXT = 4.5;

/**
 * @param {string} hex #RRGGBB
 * @returns {[number, number, number]}
 */
export function hexToRgb(hex) {
    const digits = hex.replace('#', '');

    return [0, 2, 4].map((offset) => parseInt(digits.slice(offset, offset + 2), 16));
}

/**
 * WCAG 2.x relative luminance of a #RRGGBB colour.
 *
 * @param {string} hex
 * @returns {number}
 */
export function relativeLuminance(hex) {
    const [red, green, blue] = hexToRgb(hex).map((channel) => {
        const value = channel / 255;

        return value <= 0.03928 ? value / 12.92 : ((value + 0.055) / 1.055) ** 2.4;
    });

    return 0.2126 * red + 0.7152 * green + 0.0722 * blue;
}

/**
 * @param {string} firstHex
 * @param {string} secondHex
 * @returns {number} Ratio between 1 and 21.
 */
export function contrastRatio(firstHex, secondHex) {
    const [lighter, darker] = [relativeLuminance(firstHex), relativeLuminance(secondHex)].sort((a, b) => b - a);

    return (lighter + 0.05) / (darker + 0.05);
}

/**
 * Returns the text ink (dark or white) with the highest contrast on the given background.
 *
 * @param {string} backgroundHex
 * @returns {string}
 */
export function pickInk(backgroundHex) {
    return contrastRatio(INK_DARK, backgroundHex) >= contrastRatio(INK_LIGHT, backgroundHex) ? INK_DARK : INK_LIGHT;
}

/**
 * Mixes two colours in sRGB, matching CSS `color-mix(in srgb, accent share%, base)`.
 *
 * @param {string} accentHex
 * @param {string} baseHex
 * @param {number} accentShare Fraction between 0 and 1 for the accent part.
 * @returns {string} #RRGGBB
 */
export function mixHex(accentHex, baseHex, accentShare) {
    const accent = hexToRgb(accentHex);
    const base = hexToRgb(baseHex);
    const mixed = accent.map((channel, index) => Math.round(channel * accentShare + base[index] * (1 - accentShare)));

    return `#${mixed.map((channel) => channel.toString(16).padStart(2, '0')).join('').toUpperCase()}`;
}
