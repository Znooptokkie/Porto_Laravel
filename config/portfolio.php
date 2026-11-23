<?php

return [
    'name' => 'Atilla Oomen',

    /*
     * Year in which ROC Leiden merged into mboRijnland. The timeline text counts the years since then.
     */
    'roc_leiden_merge_year' => 2019,

    'links' => [
        'github' => 'https://github.com/znooptokkie/',
        'linkedin' => 'https://www.linkedin.com/in/atilla-oomen-3a4b78335',
        /*
         * E-mailadres voor de mailto-link in de hero. Zolang dit null is, wordt het icoon niet-interactief getoond.
         */
        'email' => 'oomenatilla@gmail.com',
    ],

    /*
     * Light and dark logo per company. Each file is the 88x88 window of the Figma logo sheet (frame 98:11912) that
     * the 48px logo circle shows, isolated so the sheet itself is no longer referenced. Logos keep their own colours.
     */
    'internship_logos' => [
        'Webprepare' => [
            'light' => 'images/companies/webprepare.webp',
            'dark' => 'images/companies/webprepare.webp',
        ],
        'Battlebot' => [
            'light' => 'images/companies/mborijnland.svg',
            'dark' => 'images/companies/mborijnland.svg',
        ],
    ],

    /*
     * Preset accent colours shown in the preferences popover. The first entry is the default.
     */
    'accent_presets' => [
        ['key' => 'green', 'hex' => '#2ECC71'],
        ['key' => 'purple', 'hex' => '#9F2ECC'],
        ['key' => 'blue', 'hex' => '#1c25cd'],
        ['key' => 'red', 'hex' => '#CC2E2E'],
        ['key' => 'orange', 'hex' => '#FFA200'],
    ],
];
