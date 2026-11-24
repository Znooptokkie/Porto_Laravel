/**
 * Project overview filters and the project image viewer.
 * Desktop: every filter opens a popover under its own trigger. Mobile: all filters live in one bottom sheet.
 * Any change submits the filter form, so the server returns the filtered list.
 */
export function initProjects() {
    document.querySelectorAll('[data-project-filters]').forEach(bindFilters);
    document.querySelectorAll('[data-project-media]').forEach(bindMedia);
}

function bindFilters(form) {
    const groups = [...form.querySelectorAll('[data-project-filter]')];

    groups.forEach((group) => {
        const trigger = group.querySelector('[data-project-filter-trigger]');

        trigger?.addEventListener('click', () => {
            const willOpen = !group.classList.contains('is-open');

            closeGroups(groups);
            setOpen(group, willOpen);
        });
    });

    document.addEventListener('click', (event) => {
        if (!groups.some((group) => group.contains(event.target))) {
            closeGroups(groups);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        const openGroup = groups.find((group) => group.classList.contains('is-open'));

        if (openGroup) {
            openGroup.querySelector('[data-project-filter-trigger]')?.focus();
            closeGroups(groups);
        }
    });

    form.addEventListener('change', () => refreshResults(form));

    bindSheet(form);
}

let activeRequest = null;

/**
 * Fetches the list for the current filter values and swaps only the result cards, so the page is not reloaded.
 * The URL is updated so a filtered view can still be shared or reloaded.
 */
async function refreshResults(form) {
    const results = document.querySelector('[data-project-results]');
    const url = `${form.action}?${new URLSearchParams(new FormData(form)).toString()}`;

    if (!results) {
        window.location.assign(url);
        return;
    }

    activeRequest?.abort();
    activeRequest = new AbortController();

    try {
        const response = await fetch(url, { headers: { Accept: 'text/html' }, signal: activeRequest.signal });

        if (!response.ok) {
            window.location.assign(url);
            return;
        }

        const parsed = new DOMParser().parseFromString(await response.text(), 'text/html');
        const fresh = parsed.querySelector('[data-project-results]');

        if (!fresh) {
            window.location.assign(url);
            return;
        }

        results.replaceWith(fresh);

        swapSlot(parsed, '[data-project-count]');
        swapSlot(parsed, '[data-leetcode-more]');
        history.replaceState(null, '', url);
    } catch (error) {
        if (error.name !== 'AbortError') {
            window.location.assign(url);
        }
    }
}

/**
 * Replaces an element outside the results with the version of the fresh page, or removes it when the fresh page has none.
 */
function swapSlot(parsed, selector) {
    const current = document.querySelector(selector);
    const fresh = parsed.querySelector(selector);

    if (current && fresh) {
        current.replaceWith(fresh);
    } else if (current) {
        current.remove();
    }
}

/**
 * The sheet slides down before it closes. The dialog stays open until that slide has finished, the same way the header
 * menu keeps its panel until the slide-up has played. Escape goes through the same slide.
 */
function bindSheet(form) {
    const sheet = form.querySelector('[data-project-sheet]');

    if (!sheet || typeof sheet.showModal !== 'function') {
        return;
    }

    const close = () => {
        if (sheet.dataset.closing === 'true') {
            return;
        }

        if (document.documentElement.dataset.motion === 'off') {
            sheet.close();
            return;
        }

        sheet.dataset.closing = 'true';

        const finish = (event) => {
            if (event && event.target !== sheet) {
                return;
            }

            sheet.removeEventListener('animationend', finish);
            window.clearTimeout(timer);
            sheet.close();
            delete sheet.dataset.closing;
        };

        sheet.addEventListener('animationend', finish);
        const timer = window.setTimeout(finish, 400);
    };

    form.querySelector('[data-project-sheet-open]')?.addEventListener('click', () => sheet.showModal());
    form.querySelector('[data-project-sheet-close]')?.addEventListener('click', close);
    sheet.addEventListener('cancel', (event) => {
        event.preventDefault();
        close();
    });
}

function setOpen(group, open) {
    group.classList.toggle('is-open', open);
    group.querySelector('[data-project-filter-trigger]')?.setAttribute('aria-expanded', String(open));
}

function closeGroups(groups) {
    groups.forEach((group) => setOpen(group, false));
}

const MEDIA_MOTION_CLASSES = ['is-leaving-to-left', 'is-leaving-to-right', 'is-entering-from-left', 'is-entering-from-right'];

/* Same breakpoint as the mobile layout in projects.css (max-width: 600px). */
const MOBILE_MEDIA_QUERY = '(max-width: 600px)';

/**
 * Shows the slides that belong to the current screen size. A slide has scope "both", "desktop" or "mobile"; the counter
 * shows the position among the slides of this screen size. Changing the screen size starts again at the first slide.
 */
function bindMedia(viewer) {
    const allSlides = [...viewer.querySelectorAll('[data-project-media-scope]')];
    const counter = viewer.querySelector('[data-project-media-counter]');
    const caption = viewer.querySelector('[data-project-media-caption-text]');
    const mobileQuery = window.matchMedia(MOBILE_MEDIA_QUERY);
    let slides = [];
    let current = 0;

    const visibleSlides = () => {
        const breakpoint = mobileQuery.matches ? 'mobile' : 'desktop';

        return allSlides.filter((slide) => ['both', breakpoint].includes(slide.dataset.projectMediaScope));
    };

    /**
     * Moves to another slide. Going to the previous slide: the current one leaves to the right and the previous one enters from the left. Going forward is the mirror image.
     */
    const show = (index, direction) => {
        const previous = current;

        current = (index + slides.length) % slides.length;

        allSlides.forEach((slide) => {
            slide.classList.remove(...MEDIA_MOTION_CLASSES, 'is-active');
            slide.inert = true;
            slide.setAttribute('aria-hidden', 'true');
        });

        slides.forEach((slide, position) => {
            const active = position === current;

            slide.classList.toggle('is-active', active);
            slide.inert = !active;
            slide.setAttribute('aria-hidden', String(!active));
        });

        if (direction && previous !== current && slides[previous]) {
            const movingBack = direction === 'previous';

            slides[previous].classList.add(movingBack ? 'is-leaving-to-right' : 'is-leaving-to-left');
            slides[current].classList.add(movingBack ? 'is-entering-from-left' : 'is-entering-from-right');
        }

        const counterKey = mobileQuery.matches ? 'projectMediaCounterMobile' : 'projectMediaCounterDesktop';

        if (counter) {
            counter.textContent = slides[current].dataset[counterKey] ?? '';
        }

        if (caption) {
            caption.textContent = slides[current].dataset.projectMediaCaption ?? '';
        }
    };

    const reset = () => {
        slides = visibleSlides();
        viewer.toggleAttribute('data-single', slides.length < 2);
        show(0);
    };

    viewer.dataset.enhanced = '';
    reset();
    mobileQuery.addEventListener('change', reset);

    viewer.querySelector('[data-project-media-prev]')?.addEventListener('click', () => show(current - 1, 'previous'));
    viewer.querySelector('[data-project-media-next]')?.addEventListener('click', () => show(current + 1, 'next'));
}
