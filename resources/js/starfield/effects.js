import { BURST, FEATURES, METEOR, SHOOTING_STAR } from './config.js';

/**
 * @typedef {{ x: number, y: number, speedX: number, speedY: number, radius: number, life: number }} Particle
 * @typedef {{ x: number, y: number, life: number }} Core
 * @typedef {{ x: number, y: number, speedX: number, speedY: number, life: number }} ShootingStar
 */

/**
 * Short-lived effects: collision bursts (particles and an optional core flash) and shooting stars.
 *
 * @param {HTMLCanvasElement} canvas
 */
export function createEffects(canvas) {
    /** @type {Particle[]} */
    let particles = [];
    /** @type {Core[]} */
    let cores = [];
    /** @type {ShootingStar[]} */
    let shootingStars = [];

    /**
     * @param {number} x
     * @param {number} y
     */
    const spawnBurst = (x, y) => {
        for (let index = 0; index < BURST.particles; index++) {
            const angle = Math.random() * Math.PI * 2;
            const speed = 0.6 + Math.random() * 1;

            particles.push({
                x,
                y,
                speedX: Math.cos(angle) * speed,
                speedY: Math.sin(angle) * speed,
                radius: 0.6 + Math.random() * 0.6,
                life: BURST.particleLife,
            });
        }

        if (FEATURES.explosionCore) {
            cores.push({ x, y, life: BURST.coreLife });
        }
    };

    /**
     * Shooting stars enter at the top edge and always move downward, tilted at most maxTilt
     * away from straight down, so they can come in diagonally but never travel upward.
     */
    const spawnShootingStar = () => {
        const angle = Math.PI / 2 + (Math.random() - 0.5) * 2 * SHOOTING_STAR.maxTilt;

        shootingStars.push({
            x: Math.random() * canvas.width,
            y: 0,
            speedX: Math.cos(angle) * SHOOTING_STAR.speed,
            speedY: Math.sin(angle) * SHOOTING_STAR.speed,
            life: SHOOTING_STAR.life,
        });
    };

    const launchMeteorShower = () => {
        for (let index = 0; index < METEOR.count; index++) {
            setTimeout(spawnShootingStar, Math.random() * METEOR.spread);
        }
    };

    const update = () => {
        for (const particle of particles) {
            particle.x += particle.speedX;
            particle.y += particle.speedY;
            particle.speedX *= BURST.particleDrag;
            particle.speedY *= BURST.particleDrag;
            particle.life -= 1;
        }

        particles = particles.filter((particle) => particle.life > 0);

        for (const core of cores) {
            core.life -= 1;
        }

        cores = cores.filter((core) => core.life > 0);

        for (const shootingStar of shootingStars) {
            shootingStar.x += shootingStar.speedX;
            shootingStar.y += shootingStar.speedY;
            shootingStar.life -= 1;
        }

        shootingStars = shootingStars.filter((shootingStar) => shootingStar.life > 0);
    };

    /**
     * @param {CanvasRenderingContext2D} ctx
     * @param {string} accent
     * @param {string} coreColor
     */
    const drawBursts = (ctx, accent, coreColor) => {
        ctx.shadowBlur = 0;
        ctx.fillStyle = accent;

        for (const particle of particles) {
            ctx.globalAlpha = particle.life / BURST.particleLife;
            ctx.beginPath();
            ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
            ctx.fill();
        }

        if (FEATURES.explosionCore) {
            ctx.fillStyle = coreColor;

            for (const core of cores) {
                const progress = 1 - core.life / BURST.coreLife;

                ctx.globalAlpha = core.life / BURST.coreLife;
                ctx.beginPath();
                ctx.arc(core.x, core.y, 1 + progress * 2, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        ctx.globalAlpha = 1;
    };

    /**
     * @param {CanvasRenderingContext2D} ctx
     * @param {ShootingStar} shootingStar
     * @param {string} accent
     */
    const drawShootingStar = (ctx, shootingStar, accent) => {
        const { x, y, speedX, speedY, life } = shootingStar;
        const magnitude = Math.hypot(speedX, speedY);
        const tailX = x - (speedX / magnitude) * SHOOTING_STAR.tail;
        const tailY = y - (speedY / magnitude) * SHOOTING_STAR.tail;
        const gradient = ctx.createLinearGradient(tailX, tailY, x, y);

        gradient.addColorStop(0, 'transparent');
        gradient.addColorStop(1, accent);

        // Fades in and out over its lifetime, so it appears and disappears softly.
        ctx.globalAlpha = Math.sin(Math.PI * (1 - life / SHOOTING_STAR.life));
        ctx.strokeStyle = gradient;
        ctx.lineWidth = 1.5;
        ctx.shadowColor = accent;
        ctx.shadowBlur = 8;
        ctx.beginPath();
        ctx.moveTo(tailX, tailY);
        ctx.lineTo(x, y);
        ctx.stroke();

        ctx.globalAlpha = 1;
        ctx.shadowBlur = 0;
    };

    /**
     * @param {CanvasRenderingContext2D} ctx
     * @param {string} accent
     */
    const drawShootingStars = (ctx, accent) => {
        for (const shootingStar of shootingStars) {
            drawShootingStar(ctx, shootingStar, accent);
        }
    };

    return {
        spawnBurst,
        spawnShootingStar,
        launchMeteorShower,
        hasShootingStar: () => shootingStars.length > 0,
        update,
        drawBursts,
        drawShootingStars,
    };
}
