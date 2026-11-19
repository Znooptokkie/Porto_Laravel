import { applyPreferences, readPreferences } from './preferences.js';
import { initHeader } from './header.js';
import { initTimelineReveal } from './timeline.js';
import { initAboutAccordions } from './about-accordions.js';
import { initProjects } from './projects.js';
import { initLeetcode } from './leetcode.js';
import { initCodeEntries } from './code-entries.js';
import { initStarfield } from './starfield/index.js';

applyPreferences(readPreferences());

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initHeader();
        initTimelineReveal();
        initAboutAccordions();
        initProjects();
        initLeetcode();
        initCodeEntries();
        initStarfield();
    });
} else {
    initHeader();
    initTimelineReveal();
    initAboutAccordions();
    initProjects();
    initLeetcode();
    initCodeEntries();
    initStarfield();
}
