<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | Specify the base uri for each service.
    |
    */

    'services' => [
        'facebook' => [
            'uri' => 'https://www.facebook.com/sharer/sharer.php',
        ],
        'twitter' => [
            'uri'  => 'https://twitter.com/intent/tweet',
            'text' => 'Default share text',
        ],
        'reddit' => [
            'uri'  => 'https://www.reddit.com/submit',
            'text' => 'Default share text',
        ],
    ],

];
