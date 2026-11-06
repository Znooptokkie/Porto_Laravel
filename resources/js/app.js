import { applyPreferences, readPreferences } from './preferences.js';
import { initHeader } from './header.js';

applyPreferences(readPreferences());

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeader);
} else {
    initHeader();
}
