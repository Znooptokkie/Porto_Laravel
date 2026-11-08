/**
 * Feature switches and tuning values for the star background.
 * Set an entry in FEATURES to false to turn that effect off.
 */
export const FEATURES = {
    twinkle: true,
    cursorInteraction: true,
    parallax: true,
    timelineFlash: true,
    meteorShowerEasterEgg: true,
    themeAdaptiveDensity: true,
    explosionCore: true,
    starStream: true,
};

export const STARS = {
    count: 150,
    countLight: 120,
    smallScreenWidth: 720,
    smallScreenFactor: 0.6,
    maxSpeed: 1.5,
    speedRecovery: 0.02,
    contactPadding: 1,
};

export const CURSOR = {
    radius: 120,
    force: 0.05,
};

export const PARALLAX = {
    mouse: 30,
    scroll: 0.05,
    easing: 0.08,
};

export const BURST = {
    particles: 8,
    particleLife: 30,
    particleDrag: 0.96,
    coreLife: 8,
};

export const SHOOTING_STAR = {
    minDelay: 15000,
    maxDelay: 30000,
    life: 60,
    speed: 6,
    tail: 90,
    maxTilt: Math.PI / 4,
};

/**
 * A dense streak of stars that enters from a random direction, crosses the screen and ends.
 * length is a fraction of the screen diagonal, width is in px,
 * speed is in px per frame and is chosen randomly for each streak.
 */
export const STAR_STREAM = {
    minDelay: 18000,
    maxDelay: 48000,
    count: 70,
    length: 0.2,
    width: 20,
    minSpeed: 0.5,
    maxSpeed: 1,
    maxRadius: 1.4,
};

export const FLASH = {
    duration: 600,
    boost: 1.6,
};

export const METEOR = {
    clicks: 10,
    clickWindow: 4000,
    count: 12,
    spread: 3000,
};
