/**
 * Star background on a fixed canvas behind the page.
 * Stars use the --accent token, so they follow the accent colour.
 * With animations off (data-motion="off") the stars stand still, no parallax or cursor push runs,
 * and no bursts, shooting stars or meteor showers appear.
 * The starfield is only shown in dark mode; light mode renders an empty canvas.
 */
import { FEATURES, FLASH, METEOR, SHOOTING_STAR } from './config.js';
import { createStarField } from './stars.js';
import { createEffects } from './effects.js';

/**
 * @param {string} canvasId
 */
export function initStarfield(canvasId = 'starfield') {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas?.getContext('2d');

    if (!canvas || !ctx) {
        return;
    }

    const starField = createStarField(canvas);
    const effects = createEffects(canvas);
    /** @type {{ x: number, y: number } | null} */
    let pointer = null;
    let nextShootingStarAt = 0;
    let flashUntil = 0;
    /** @type {number[]} */
    const clickTimes = [];

    const motionOn = () => document.documentElement.dataset.motion !== 'off';
    const starsVisible = () => document.documentElement.dataset.theme === 'dark';

    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };

    /**
     * @param {number} now
     */
    const scheduleShootingStar = (now) => {
        nextShootingStarAt = now + SHOOTING_STAR.minDelay + Math.random() * (SHOOTING_STAR.maxDelay - SHOOTING_STAR.minDelay);
    };

    /**
     * @param {number} now
     */
    const frame = (now) => {
        if (!starsVisible()) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            requestAnimationFrame(frame);

            return;
        }

        const styles = getComputedStyle(document.documentElement);
        const accent = styles.getPropertyValue('--accent').trim();
        const coreColor = styles.getPropertyValue('--color-text-strong').trim();
        const motion = motionOn();

        starField.sync();
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (motion) {
            starField.move(pointer, (x, y) => effects.spawnBurst(x, y));
            effects.update();

            if (!effects.hasShootingStar() && now >= nextShootingStarAt) {
                effects.spawnShootingStar();
                scheduleShootingStar(now);
            }
        }

        starField.updatePositions(pointer, motion);
        starField.draw(ctx, { accent, motion, flashing: now < flashUntil });
        effects.drawBursts(ctx, accent, coreColor);
        effects.drawShootingStars(ctx, accent);

        requestAnimationFrame(frame);
    };

    const bindTimelineFlash = () => {
        const chapters = document.querySelectorAll('.timeline-chapter');

        if (!FEATURES.timelineFlash || !chapters.length || !('IntersectionObserver' in window)) {
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) {
                    continue;
                }

                observer.unobserve(entry.target);

                if (motionOn() && starsVisible()) {
                    flashUntil = performance.now() + FLASH.duration;
                    effects.spawnShootingStar();
                }
            }
        }, { threshold: 0.3 });

        chapters.forEach((chapter) => observer.observe(chapter));
    };

    const bindMeteorEasterEgg = () => {
        const name = document.querySelector('.hero__name');

        if (!FEATURES.meteorShowerEasterEgg || !name) {
            return;
        }

        name.addEventListener('click', () => {
            if (!motionOn() || !starsVisible()) {
                return;
            }

            const now = performance.now();

            clickTimes.push(now);

            while (clickTimes.length && now - clickTimes[0] > METEOR.clickWindow) {
                clickTimes.shift();
            }

            if (clickTimes.length >= METEOR.clicks) {
                clickTimes.length = 0;
                effects.launchMeteorShower();
            }
        });
    };

    window.addEventListener('resize', resizeCanvas);
    window.addEventListener('pointermove', (event) => {
        pointer = { x: event.clientX, y: event.clientY };
    });
    document.documentElement.addEventListener('mouseleave', () => {
        pointer = null;
    });

    resizeCanvas();
    starField.sync();
    scheduleShootingStar(performance.now());
    bindTimelineFlash();
    bindMeteorEasterEgg();
    requestAnimationFrame(frame);
}
