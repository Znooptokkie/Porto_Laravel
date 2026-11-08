/**
 * Reveals timeline steps one by one while the visitor scrolls.
 * The first step is always visible; the others fade in when they enter the viewport.
 * With animations off, every step stays visible.
 */
export function initTimelineReveal() {
    const chapters = [...document.querySelectorAll('.timeline-chapter')];

    if (chapters.length < 2 || document.documentElement.dataset.motion === 'off' || !('IntersectionObserver' in window)) {
        return;
    }

    const hidden = chapters.slice(1);
    hidden.forEach((chapter) => chapter.classList.add('timeline-chapter--hidden'));

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            // Reveal this step and every earlier step, so a jump down the page never leaves a gap.
            const index = chapters.indexOf(entry.target);
            chapters.slice(0, index + 1).forEach((chapter) => {
                chapter.classList.remove('timeline-chapter--hidden');
                observer.unobserve(chapter);
            });
        });
    }, { threshold: 0.2 });

    hidden.forEach((chapter) => observer.observe(chapter));
}
