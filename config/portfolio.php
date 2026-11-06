<?php

return [
    'name' => 'Atilla Oomen',

    'links' => [
        'github' => 'https://github.com/znooptokkie/',
        'linkedin' => 'https://www.linkedin.com/in/atilla-oomen-3a4b78335',
        /*
         * E-mailadres voor de mailto-link in de hero. Zolang dit null is, wordt het icoon niet-interactief getoond.
         */
        'email' => null,
    ],

    /*
     * Light and dark logo per company. Each file is the 88x88 window of the Figma logo sheet (frame 98:11912) that
     * the 48px logo circle shows, isolated so the sheet itself is no longer referenced. Logos keep their own colours.
     */
    'internship_logos' => [
        'Webprepare' => [
            'light' => 'images/figma/light/webprepareLogo.png',
            'dark' => 'images/figma/dark/WebprepareLogo.png',
        ],
        'Battlebot' => [
            'light' => 'images/figma/light/battlebotLogo.png',
            'dark' => 'images/figma/dark/BattlebotLogo.png',
        ],
    ],

    /*
     * Preset accent colours shown in the preferences popover. The first entry is the default.
     */
    'accent_presets' => [
        ['key' => 'green', 'hex' => '#2ECC71'],
        ['key' => 'purple', 'hex' => '#9F2ECC'],
        ['key' => 'blue', 'hex' => '#0009FF'],
        ['key' => 'red', 'hex' => '#CC2E2E'],
        ['key' => 'orange', 'hex' => '#FFA200'],
    ],
];
