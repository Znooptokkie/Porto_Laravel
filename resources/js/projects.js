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

        const fresh = new DOMParser().parseFromString(await response.text(), 'text/html').querySelector('[data-project-results]');

        if (!fresh) {
            window.location.assign(url);
            return;
        }

        results.replaceWith(fresh);
        history.replaceState(null, '', url);
    } catch (error) {
        if (error.name !== 'AbortError') {
            window.location.assign(url);
        }
    }
}

function bindSheet(form) {
    const sheet = form.querySelector('[data-project-sheet]');

    if (!sheet || typeof sheet.showModal !== 'function') {
        return;
    }

    form.querySelector('[data-project-sheet-open]')?.addEventListener('click', () => sheet.showModal());
    form.querySelector('[data-project-sheet-close]')?.addEventListener('click', () => sheet.close());
}

function setOpen(group, open) {
    group.classList.toggle('is-open', open);
    group.querySelector('[data-project-filter-trigger]')?.setAttribute('aria-expanded', String(open));
}

function closeGroups(groups) {
    groups.forEach((group) => setOpen(group, false));
}

const MEDIA_MOTION_CLASSES = ['is-leaving-to-left', 'is-leaving-to-right', 'is-entering-from-left', 'is-entering-from-right'];

function bindMedia(viewer) {
    const slides = [...viewer.querySelectorAll('[data-project-media-slide]')];
    const counter = viewer.querySelector('[data-project-media-counter]');
    const caption = viewer.querySelector('[data-project-media-caption-text]');
    let current = 0;

    /**
     * Moves to another slide. Going to the previous slide: the current one leaves to the right and the previous one enters from the left. Going forward is the mirror image.
     */
    const show = (index, direction) => {
        const previous = current;

        current = (index + slides.length) % slides.length;

        slides.forEach((slide, position) => {
            const active = position === current;

            slide.classList.remove(...MEDIA_MOTION_CLASSES);
            slide.classList.toggle('is-active', active);
            slide.inert = !active;
            slide.setAttribute('aria-hidden', String(!active));
        });

        if (previous !== current) {
            const movingBack = direction === 'previous';

            slides[previous].classList.add(movingBack ? 'is-leaving-to-right' : 'is-leaving-to-left');
            slides[current].classList.add(movingBack ? 'is-entering-from-left' : 'is-entering-from-right');
        }

        if (counter) {
            counter.textContent = slides[current].dataset.projectMediaSlide ?? '';
        }

        if (caption) {
            caption.textContent = slides[current].dataset.projectMediaCaption ?? '';
        }
    };

    viewer.querySelector('[data-project-media-prev]')?.addEventListener('click', () => show(current - 1, 'previous'));
    viewer.querySelector('[data-project-media-next]')?.addEventListener('click', () => show(current + 1, 'next'));
}
