<?php

return [
    /* -----------------------------------------------------------------
     |  Credentials
     | -----------------------------------------------------------------
     */

    'secret' => env('NOCAPTCHA_SECRET', 'no-captcha-secret'),
    'sitekey' => env('NOCAPTCHA_SITEKEY', 'no-captcha-sitekey'),

    /* -----------------------------------------------------------------
     |  Localization
     | -----------------------------------------------------------------
     */

    'lang' => 'en',

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'data-theme' => 'light', // 'light', 'dark'
        'data-type' => 'image', // 'image', 'audio'
        'data-size' => 'normal', // 'normal', 'compact'
    ],
];
