<?php

return [
    'show_website_to_robots' => env('SHOW_WEBSITE_TO_ROBOTS', false),
    'enable_facebook_tracking' => env('ENABLE_FACEBOOK_TRACKING', false),
    'enable_google_tag_tracking' => env('ENABLE_GOOGLE_TAG_TRACKING', false),
    'opening_hours_start' => env('OPENING_HOURS_START', '08:30:00'),
    'opening_hours_end' => env('OPENING_HOURS_END', '18:30:00'),
    'social_networks' => [
        'default_image' => '/images/logo.png',
        'facebook' => 'https://www.facebook.com/WebSite/',
        'twitter' => '',
    ],
    'slogan' => 'Your website catchy slogan',
    'googleSiteVerification' => env('GOOGLE_SITE_VERIFICATION'),
    'facebookDomainVerification' => env('FACEBOOK_DOMAIN_VERIFICATION'),
    'googleTagManager' => env('GOOGLE_TAG_MANAGER'),
    'googleTagManagerAuth' => env('GOOGLE_TAG_MANAGER_AUTH'),
    'googleTagManagerEnv' => env('GOOGLE_TAG_MANAGER_ENV'),

    'organization' => [
        'phone' => '(581) 703-0733',
        'postal_code' => 'G1N 4C2',
        'address' => '210-2327 boulevard du Versant Nord',
        'city' => 'Québec',
        'region' => 'QC',
        'country' => 'Canada',
    ],
];
