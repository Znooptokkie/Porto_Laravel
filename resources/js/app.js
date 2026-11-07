import { applyPreferences, readPreferences } from './preferences.js';
import { initHeader } from './header.js';
import { initTimelineReveal } from './timeline.js';
import { initStarfield } from './starfield/index.js';

applyPreferences(readPreferences());

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initHeader();
        initTimelineReveal();
        initStarfield();
    });
} else {
    initHeader();
    initTimelineReveal();
    initStarfield();
}
