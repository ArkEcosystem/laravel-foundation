<?php

declare(strict_types=1);

return [
    'consent_modal' => [
        'title'         => 'This website uses cookies.',
        'description'   => 'By clicking "Accept" you agree to the storing of cookies on your device to enhance site navigation, analyze site usage and assist in our marketing efforts.',
        'primary_btn'   => [
            'text' => 'Accept',
        ],
        'secondary_btn' => [
            'text' => 'Reject',
        ],
    ],

    'settings_modal' => [
        'title'                => 'Cookie Settings',
        'save_settings_btn'    => 'Accept Selected',
        'accept_all_btn'       => 'Accept All',
        'reject_all_btn'       => 'Reject All',
        'close_btn_label'      => 'Close',
        'cookie_table_headers' => [
            'name'        => 'Name',
            'domain'      => 'Domain',
            'description' => 'Description',
        ],
        'blocks' => [
            'header' => [
                'title'       => 'Cookie Usage',
                'description' => config('app.name').' uses cookies in order to provide you with a safer and more streamlined experience. Learn more by reading our <a href="/cookie-policy">Cookie Policy</a>.',
            ],
            'necessary_cookies' => [
                'title'       => 'Strictly Necessary Cookies',
                'description' => 'These cookies are essential for the proper functioning of our website and don\'t store any user-identifiable data. Without these cookies, the website would not work properly. This option cannot be disabled.',
            ],
            'analytics' => [
                'title'                 => 'Performance and Analytics Cookies',
                'description'           => 'These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you.',
                'analytics_description' => 'This cookie is installed by Google Analytics and used for the site’s analytics report. This information is stored anonymously and assigned a random number to identify unique visitors.',
                'session_description'   => 'This cookie is installed by Google Analytics for session management.',
            ],
            'footer' => [
                'title'       => 'More Information',
                'description' => 'For any queries in relation to our policy on cookies and your choices, please <a href="/contact">contact us</a>.',
            ],
        ],
    ],
];
