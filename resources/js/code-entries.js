import Prism from 'prismjs';
import 'prismjs/components/prism-bash';

const COPIED_FEEDBACK_MS = 2000;
const COPIED_POPOVER_MS = 3000;
const POPOVER_GAP_PX = 8;

let popoverTimer;

/**
 * Colours the code entries with Prism and lets the visitor copy a code block or an install command to the clipboard.
 */
export function initCodeEntries() {
    document.querySelectorAll('[data-code-entries]').forEach((list) => {
        Prism.highlightAllUnder(list);

        list.addEventListener('click', (event) => {
            const button = event.target.closest('[data-copy-text]');

            if (button && list.contains(button)) {
                copyToClipboard(button, list.querySelector('[data-copy-popover]'));
            }
        });
    });
}

/**
 * Copies the button's text and gives feedback on the button and in the popover. Nothing changes when the browser
 * refuses access to the clipboard.
 */
async function copyToClipboard(button, popover) {
    try {
        await navigator.clipboard.writeText(button.dataset.copyText);
    } catch {
        return;
    }

    button.classList.add('is-copied');
    button.setAttribute('aria-label', button.dataset.copiedLabel);

    setTimeout(() => {
        button.classList.remove('is-copied');
        button.setAttribute('aria-label', button.dataset.copyLabel);
    }, COPIED_FEEDBACK_MS);

    if (popover) {
        showPopover(button, popover);
    }
}

/**
 * Shows the popover above the button, or below it when there is no room above, and hides it again after a few seconds.
 */
function showPopover(button, popover) {
    clearTimeout(popoverTimer);

    if (!popover.matches(':popover-open')) {
        popover.showPopover();
    }

    const anchor = button.getBoundingClientRect();
    const { offsetWidth: width, offsetHeight: height } = popover;
    const left = Math.min(
        Math.max(anchor.left + anchor.width / 2 - width / 2, POPOVER_GAP_PX),
        window.innerWidth - width - POPOVER_GAP_PX,
    );
    let top = anchor.top - height - POPOVER_GAP_PX;

    if (top < POPOVER_GAP_PX) {
        top = anchor.bottom + POPOVER_GAP_PX;
    }

    popover.style.left = `${left}px`;
    popover.style.top = `${top}px`;

    popoverTimer = setTimeout(() => popover.hidePopover(), COPIED_POPOVER_MS);
}
