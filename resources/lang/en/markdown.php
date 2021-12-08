<?php

declare(strict_types=1);

return [
    'modals' => [
        'embedLink' => [
            'title' => 'Add Embed Link',
            'form' => [
                'url' => 'URL',
                'caption' => 'Caption',
            ]
        ],
        'embedTweet' => [
            'title' => 'Embed Tweet',
            'form' => [
                'url' => 'Tweet URL',
                'url_placeholder' => 'https://twitter.com/arkecosystem/status/20',
            ]
        ],
        'embedPodcast' => [
            'title' => 'Embed Simplecast Podcast',
            'form' => [
                'url' => 'Simplecast URL or ID',
            ]
        ]
    ]
];
