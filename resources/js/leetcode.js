import Prism from 'prismjs';
import 'prismjs/components/prism-python';
import 'prismjs/components/prism-typescript';

/**
 * Colours the solution code with Prism. Prism highlights the markup present on page load; when a search or filter
 * swaps the problem list, the new code blocks are highlighted here. Only direct children are observed, so the
 * highlighting itself does not trigger another pass.
 *
 * Problems solved in several languages show a tab per language. Tabs are handled on the list, so they keep working
 * after a filter has swapped the results.
 */
export function initLeetcode() {
    document.querySelectorAll('[data-leetcode-list]').forEach((list) => {
        Prism.highlightAllUnder(list);

        new MutationObserver(() => Prism.highlightAllUnder(list)).observe(list, { childList: true });

        initLoadMore(list);

        list.addEventListener('click', (event) => {
            const tab = event.target.closest('[data-leetcode-tab]');

            if (tab) {
                selectTab(tab);
            }
        });

        list.addEventListener('keydown', (event) => {
            const tab = event.target.closest('[data-leetcode-tab]');

            if (!tab) {
                return;
            }

            const tabs = [...tab.parentElement.querySelectorAll('[data-leetcode-tab]')];
            const current = tabs.indexOf(tab);
            const next = {
                ArrowRight: (current + 1) % tabs.length,
                ArrowLeft: (current - 1 + tabs.length) % tabs.length,
                Home: 0,
                End: tabs.length - 1,
            }[event.key];

            if (next === undefined) {
                return;
            }

            event.preventDefault();
            selectTab(tabs[next], true);
        });
    });
}

/**
 * Loads the next page of problems when the sentinel at the bottom of the list comes into view. The server renders the
 * sentinel with the URL of the next page; the groups of that page are appended and the sentinel is replaced by the
 * one of the page after. A filter change swaps the sentinel too, so the sentinel is looked up again after every DOM change.
 */
function initLoadMore(list) {
    const watched = new WeakSet();

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                observer.unobserve(entry.target);
                entry.target.classList.add('is-loading');

                loadNextPage(entry.target, list).then((loaded) => {
                    entry.target.classList.remove('is-loading');

                    if (!loaded && entry.target.isConnected) {
                        observer.observe(entry.target);
                    }
                });
            }
        });
    });

    const watchSentinel = () => {
        const sentinel = list.querySelector('[data-leetcode-more]');

        if (sentinel && !watched.has(sentinel)) {
            watched.add(sentinel);
            observer.observe(sentinel);
        }
    };

    new MutationObserver(watchSentinel).observe(list, { childList: true, subtree: true });
    watchSentinel();
}

/**
 * Appends the groups of the next page. Resolves to false when nothing was loaded, so the sentinel can be watched again.
 */
async function loadNextPage(sentinel, list) {
    try {
        const response = await fetch(sentinel.dataset.nextPageUrl, { headers: { Accept: 'text/html' } });

        if (!response.ok || !sentinel.isConnected) {
            return false;
        }

        const parsed = new DOMParser().parseFromString(await response.text(), 'text/html');

        if (!sentinel.isConnected) {
            return false;
        }

        const results = list.querySelector('[data-project-results]');

        parsed.querySelectorAll('[data-project-results] > .leetcode-group').forEach((group) => {
            results.append(group);
            Prism.highlightAllUnder(group);
        });

        const nextSentinel = parsed.querySelector('[data-leetcode-more]');

        if (nextSentinel) {
            sentinel.replaceWith(nextSentinel);
        } else {
            sentinel.remove();
        }

        return true;
    } catch (error) {
        console.error(error);

        return false;
    }
}

/**
 * Marks the tab as selected and shows only the panel it controls within the same problem group.
 */
function selectTab(tab, moveFocus = false) {
    const group = tab.closest('[data-leetcode-group]');

    group.querySelectorAll(':scope > .leetcode-group__tabs [data-leetcode-tab]').forEach((otherTab) => {
        const isSelected = otherTab === tab;

        otherTab.setAttribute('aria-selected', String(isSelected));
        otherTab.tabIndex = isSelected ? 0 : -1;
    });

    group.querySelectorAll(':scope > [role="tabpanel"]').forEach((panel) => {
        panel.hidden = panel.id !== tab.getAttribute('aria-controls');
    });

    if (moveFocus) {
        tab.focus();
    }
}
