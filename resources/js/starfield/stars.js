import { CURSOR, FEATURES, FLASH, PARALLAX, STARS } from './config.js';

/**
 * @typedef {{
 *   x: number, y: number, radius: number, speedX: number, speedY: number,
 *   baseSpeedX: number, baseSpeedY: number, alpha: number, depth: number,
 *   twinklePhase: number, twinkleSpeed: number, screenX: number, screenY: number
 * }} Star
 * @typedef {{ x: number, y: number }} Pointer
 */

const wrap = (value, size) => ((value % size) + size) % size;

const clampSpeed = (value) => Math.max(-STARS.maxSpeed, Math.min(STARS.maxSpeed, value));

/**
 * The drifting stars: movement, cursor push, collisions, parallax and drawing.
 *
 * @param {HTMLCanvasElement} canvas
 */
export function createStarField(canvas) {
    /** @type {Star[]} */
    const stars = [];
    /** Pairs of star indexes that are touching, so one contact only triggers one callback. */
    const touchingPairs = new Set();
    // Smoothed parallax input: eases to zero when the cursor leaves, so the stars never snap back.
    let parallaxX = 0;
    let parallaxY = 0;

    const targetCount = () => {
        if (!FEATURES.themeAdaptiveDensity) {
            return STARS.count;
        }

        let count = document.documentElement.dataset.theme === 'light' ? STARS.countLight : STARS.count;

        if (window.innerWidth < STARS.smallScreenWidth) {
            count = Math.round(count * STARS.smallScreenFactor);
        }

        return count;
    };

    /**
     * @returns {Star}
     */
    const createStar = () => {
        const speedX = (Math.random() - 0.5) * 0.2;
        const speedY = (Math.random() - 0.5) * 0.5;

        return {
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 2,
            speedX,
            speedY,
            baseSpeedX: speedX,
            baseSpeedY: speedY,
            alpha: Math.random() * 0.8 + 0.2,
            depth: 0.3 + Math.random() * 0.7,
            twinklePhase: Math.random() * Math.PI * 2,
            twinkleSpeed: 0.01 + Math.random() * 0.02,
            screenX: 0,
            screenY: 0,
        };
    };

    const sync = () => {
        const target = targetCount();

        while (stars.length < target) {
            stars.push(createStar());
        }

        stars.length = Math.min(stars.length, target);
    };

    /**
     * @param {Star} star
     * @param {Pointer} pointer
     */
    const pushFromPointer = (star, pointer) => {
        const dx = star.x - pointer.x;
        const dy = star.y - pointer.y;
        const distance = Math.hypot(dx, dy);

        if (distance === 0 || distance >= CURSOR.radius) {
            return;
        }

        const force = (1 - distance / CURSOR.radius) * CURSOR.force;

        star.speedX = clampSpeed(star.speedX + (dx / distance) * force);
        star.speedY = clampSpeed(star.speedY + (dy / distance) * force);
    };

    /**
     * Bounces touching stars off each other and reports each new contact.
     *
     * @param {(x: number, y: number) => void} onContact
     */
    const resolveContacts = (onContact) => {
        for (let i = 0; i < stars.length; i++) {
            for (let j = i + 1; j < stars.length; j++) {
                const a = stars[i];
                const b = stars[j];
                const pairKey = `${i}-${j}`;
                const dx = b.x - a.x;
                const dy = b.y - a.y;
                const distance = Math.hypot(dx, dy);
                const contactDistance = a.radius + b.radius + STARS.contactPadding;

                if (distance >= contactDistance) {
                    touchingPairs.delete(pairKey);
                    continue;
                }

                if (!touchingPairs.has(pairKey)) {
                    touchingPairs.add(pairKey);
                    onContact((a.x + b.x) / 2, (a.y + b.y) / 2);
                }

                if (distance === 0) {
                    continue;
                }

                // Equal-mass elastic collision: swap the velocity component along the contact normal.
                const normalX = dx / distance;
                const normalY = dy / distance;
                const approach = (a.speedX - b.speedX) * normalX + (a.speedY - b.speedY) * normalY;

                if (approach > 0) {
                    a.speedX -= approach * normalX;
                    a.speedY -= approach * normalY;
                    b.speedX += approach * normalX;
                    b.speedY += approach * normalY;
                }
            }
        }
    };

    /**
     * @param {Pointer | null} pointer
     * @param {(x: number, y: number) => void} onContact
     */
    const move = (pointer, onContact) => {
        for (const star of stars) {
            star.x += star.speedX;
            star.y += star.speedY;

            if (star.x < 0) star.x = canvas.width;
            if (star.x > canvas.width) star.x = 0;
            if (star.y < 0) star.y = canvas.height;
            if (star.y > canvas.height) star.y = 0;

            if (FEATURES.twinkle) {
                star.twinklePhase += star.twinkleSpeed;
            }

            if (FEATURES.cursorInteraction && pointer) {
                pushFromPointer(star, pointer);
            }

            // Ease back to the original drift so the cursor only nudges the stars.
            star.speedX += (star.baseSpeedX - star.speedX) * STARS.speedRecovery;
            star.speedY += (star.baseSpeedY - star.speedY) * STARS.speedRecovery;
        }

        resolveContacts(onContact);
    };

    /**
     * Works out where each star is drawn. Parallax follows the cursor and scroll position,
     * and deeper stars shift less. The offset eases toward its target, so it never jumps.
     *
     * @param {Pointer | null} pointer
     * @param {boolean} motion
     */
    const updatePositions = (pointer, motion) => {
        const parallaxOn = FEATURES.parallax && motion;
        const targetX = pointer && parallaxOn ? pointer.x / canvas.width - 0.5 : 0;
        const targetY = pointer && parallaxOn ? pointer.y / canvas.height - 0.5 : 0;

        parallaxX += (targetX - parallaxX) * PARALLAX.easing;
        parallaxY += (targetY - parallaxY) * PARALLAX.easing;

        const scrollOffset = parallaxOn ? window.scrollY * PARALLAX.scroll : 0;

        for (const star of stars) {
            const offsetX = parallaxX * PARALLAX.mouse * star.depth;
            const offsetY = parallaxY * PARALLAX.mouse * star.depth - scrollOffset * star.depth;

            star.screenX = wrap(star.x + offsetX, canvas.width);
            star.screenY = wrap(star.y + offsetY, canvas.height);
        }
    };

    /**
     * @param {CanvasRenderingContext2D} ctx
     * @param {{ accent: string, motion: boolean, flashing: boolean }} options
     */
    const draw = (ctx, { accent, motion, flashing }) => {
        ctx.fillStyle = accent;
        ctx.shadowColor = accent;
        ctx.shadowBlur = 10;

        for (const star of stars) {
            let alpha = star.alpha;

            if (FEATURES.twinkle && motion) {
                alpha *= 0.7 + 0.3 * Math.sin(star.twinklePhase);
            }

            if (flashing) {
                alpha *= FLASH.boost;
            }

            ctx.globalAlpha = Math.min(1, alpha);
            ctx.beginPath();
            ctx.arc(star.screenX, star.screenY, star.radius, 0, Math.PI * 2);
            ctx.fill();
        }

        ctx.globalAlpha = 1;
        ctx.shadowBlur = 0;
    };

    return { stars, sync, move, updatePositions, draw };
}
