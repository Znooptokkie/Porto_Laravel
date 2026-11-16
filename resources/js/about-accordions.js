/**
 * Animates the height of the About page accordions when they open and close.
 * The duration comes from --motion-duration-slow, so it becomes 0 when animations are off.
 */
export function initAboutAccordions() {
    document.querySelectorAll('.about-accordion').forEach((details) => {
        const summary = details.querySelector('.about-accordion__summary');

        if (!summary) {
            return;
        }

        let activeRun = null;

        summary.addEventListener('click', (event) => {
            event.preventDefault();

            // Complete a running animation synchronously, so the state is final before the next toggle reads it.
            activeRun?.();
            activeRun = null;

            const duration = readSlowDuration();

            if (duration === 0) {
                details.open = !details.open;

                return;
            }

            activeRun = details.open ? closeAccordion(details, duration) : openAccordion(details, duration);
        });
    });
}

/**
 * @returns {() => void} Completes the animation.
 */
function openAccordion(details, duration) {
    const startHeight = details.offsetHeight;

    details.open = true;

    return animateHeight(details, startHeight, details.offsetHeight, duration);
}

/**
 * @returns {() => void} Completes the animation.
 */
function closeAccordion(details, duration) {
    details.classList.add('is-closing');

    const startHeight = details.offsetHeight;

    // Measure the collapsed height, then restore the open state so the panel can animate down to it.
    details.open = false;

    const endHeight = details.offsetHeight;

    details.open = true;

    return animateHeight(details, startHeight, endHeight, duration, () => {
        details.open = false;
        details.classList.remove('is-closing');
    });
}

/**
 * @param {HTMLDetailsElement} details
 * @param {number} from
 * @param {number} to
 * @param {number} duration
 * @param {() => void} [onFinish]
 * @returns {() => void} Completes the animation synchronously and runs onFinish once.
 */
function animateHeight(details, from, to, duration, onFinish = () => {}) {
    details.style.overflow = 'hidden';

    const animation = details.animate(
        { height: [`${from}px`, `${to}px`] },
        { duration, easing: 'ease' },
    );

    let isComplete = false;

    const complete = () => {
        if (isComplete) {
            return;
        }

        isComplete = true;
        animation.cancel();
        details.style.overflow = '';
        onFinish();
    };

    animation.onfinish = complete;

    return complete;
}

/**
 * @returns {number} The slow motion duration in milliseconds.
 */
function readSlowDuration() {
    const seconds = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--motion-duration-slow'));

    return Number.isNaN(seconds) ? 0 : seconds * 1000;
}
