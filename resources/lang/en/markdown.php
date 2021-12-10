<?php

declare(strict_types=1);

return [
    'navbar' => [
        'tooltips' => [
            'more'            => 'More',
            'undo'            => 'Undo',
            'redo'            => 'Redo',
            'bold'            => 'Bold',
            'underline'       => 'Underline',
            'italic'          => 'Italic',
            'strike'          => 'Strike',
            'blockquote'      => 'Blockquote',
            'heading'         => 'Heading :level',
            'ordered_list'    => 'Ordered List',
            'unordered_list'  => 'Unordered List',
            'table'           => 'Insert Table',
            'image'           => 'Insert Image',
            'link'            => 'Insert Link',
            'inline_code'     => 'Inline Code',
            'code_block'      => 'Insert Code Block',
            'embed_link'      => 'Embed Link',
            'embed_tweet'     => 'Embed Tweet',
            'simplecast'      => 'Embed Simplecast',
            'youtube'         => 'Embed YouTube',
            'link_collection' => 'Embed Link Collection',
            'page_reference'  => 'Embed Page Reference',
            'alert'           => 'Embed Alert',
        ],
    ],
    'modals' => [
        'embedLink' => [
            'title' => 'Add Embed Link',
            'form'  => [
                'url'     => 'URL',
                'caption' => 'Caption',
            ],
        ],
        'embedTweet' => [
            'title' => 'Embed Tweet',
            'form'  => [
                'url'             => 'Tweet URL',
                'url_placeholder' => 'https://twitter.com/arkecosystem/status/20',
            ],
        ],
        'embedPodcast' => [
            'title' => 'Embed Simplecast Podcast',
            'form'  => [
                'url' => 'Simplecast URL or ID',
            ],
        ],
        'embedYoutube' => [
            'title' => 'Embed YouTube video',
            'form'  => [
                'url' => 'Youtube URL or Video ID',
            ],
        ],
        'linkCollection' => [
            'title' => 'Link Collection',
            'form'  => [
                'name' => 'Name',
                'path' => 'Path',
            ],
        ],
        'pageReference' => [
            'title' => 'Add Page Reference',
            'form'  => [
                'url' => 'Reference path or URL',
            ],
        ],
        'image' => [
            'title' => 'Insert Image',
            'form'  => [
                'source' => 'Select image source',
                'file' => 'File',
                'link' => 'Link',
                'image' => 'Image',
                'description' => 'Description',
                'browse_files' => 'Browse files',
                'file_restrictions' => 'Max size :maxSize',
            ],
        ],
        'link' => [
            'title' => 'Embed link',
            'form'  => [
                'url' => 'URL',
                'text' => 'Link Text',
            ],
        ],
        'alert' => [
            'title' => 'Add Alert',
            'form'  => [
                'type'  => 'Alert type',
                'types' => [
                    'info'    => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'danger'  => 'Danger',
                ],
                'text' => 'Alert text',
            ],
        ],
    ],
];
