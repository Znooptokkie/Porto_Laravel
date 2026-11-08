import { BURST, FEATURES, METEOR, SHOOTING_STAR, STAR_STREAM } from './config.js';

/**
 * @typedef {{ x: number, y: number, speedX: number, speedY: number, radius: number, life: number }} Particle
 * @typedef {{ x: number, y: number, life: number }} Core
 * @typedef {{ x: number, y: number, speedX: number, speedY: number, life: number }} ShootingStar
 * @typedef {{ along: number, across: number, radius: number, alpha: number }} StreamStar
 * @typedef {{ x: number, y: number, speedX: number, speedY: number, life: number, angle: number, stars: StreamStar[] }} Stream
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
    /** @type {Stream[]} */
    let streams = [];

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

    /**
     * A narrow streak of stars from a random direction. It starts just outside the screen,
     * moves straight through it and ends just outside on the other side, at a random speed.
     */
    const spawnStream = () => {
        const angle = Math.random() * Math.PI * 2;
        const diagonal = Math.hypot(canvas.width, canvas.height);
        const length = diagonal * STAR_STREAM.length;
        const speed = STAR_STREAM.minSpeed + Math.random() * (STAR_STREAM.maxSpeed - STAR_STREAM.minSpeed);
        // The streak has to clear the screen completely, so it travels the diagonal plus its own length.
        const travel = diagonal + length;
        const directionX = Math.cos(angle);
        const directionY = Math.sin(angle);
        /** @type {StreamStar[]} */
        const stars = [];

        for (let index = 0; index < STAR_STREAM.count; index++) {
            stars.push({
                along: (Math.random() - 0.5) * length,
                across: (Math.random() - 0.5) * STAR_STREAM.width,
                radius: 0.4 + Math.random() * (STAR_STREAM.maxRadius - 0.4),
                alpha: 0.4 + Math.random() * 0.5,
            });
        }

        streams.push({
            x: canvas.width / 2 - (directionX * travel) / 2,
            y: canvas.height / 2 - (directionY * travel) / 2,
            speedX: directionX * speed,
            speedY: directionY * speed,
            life: Math.ceil(travel / speed),
            angle,
            stars,
        });
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

        for (const stream of streams) {
            stream.x += stream.speedX;
            stream.y += stream.speedY;
            stream.life -= 1;
        }

        streams = streams.filter((stream) => stream.life > 0);
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

    /**
     * @param {CanvasRenderingContext2D} ctx
     * @param {string} accent
     */
    const drawStreams = (ctx, accent) => {
        ctx.fillStyle = accent;
        ctx.shadowColor = accent;
        ctx.shadowBlur = 6;

        for (const stream of streams) {
            const cos = Math.cos(stream.angle);
            const sin = Math.sin(stream.angle);

            for (const star of stream.stars) {
                ctx.globalAlpha = star.alpha;
                ctx.beginPath();
                ctx.arc(
                    stream.x + cos * star.along - sin * star.across,
                    stream.y + sin * star.along + cos * star.across,
                    star.radius,
                    0,
                    Math.PI * 2,
                );
                ctx.fill();
            }
        }

        ctx.globalAlpha = 1;
        ctx.shadowBlur = 0;
    };

    return {
        spawnBurst,
        spawnShootingStar,
        launchMeteorShower,
        spawnStream,
        hasStream: () => streams.length > 0,
        hasShootingStar: () => shootingStars.length > 0,
        update,
        drawBursts,
        drawShootingStars,
        drawStreams,
    };
}
