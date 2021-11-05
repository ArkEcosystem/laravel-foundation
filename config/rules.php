<?php

declare(strict_types=1);

return [

    'regex' => [
        'social_media_link' => [
            'discord'      => '/(?:https?:)\/\/(?:www\.)?discord\.(gg|com)\/(?:invite\/)?[a-zA-Z0-9-_@]+/m',
            'ecency'       => '/(?:https?:)\/\/(?:www\.)?ecency\.com\/(@[a-zA-Z0-9-_@])/m',
            'facebook'     => '/(?:https?:)\/\/(?:www\.)?(?:facebook|fb|m\.facebook)\.(?:com|me)\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]+)(?:\/)?/i',
            'github'       => '/(?:https?:)\/\/(?:www\.)?github\.com\/(?P<login>[A-z0-9_-]+)(?:\/(?P<repo>[*]+)\/?)?/m',
            'hive'         => '/(?:https?:)\/\/(?:[a-zA-Z0-9-_@]+\.)?hive\.(com|blog)\/[a-zA-Z0-9-_@]+/m',
            'instagram'    => '/(?:https?:)\/\/(?:www\.)?(?:instagram\.com|instagr\.am)\/(?P<username>[a-zA-Z0-9-_@](?:(?:[a-zA-Z0-9-_@]|(?:\.(?!\.))){0,28}(?:[a-zA-Z0-9-_@]))?)/m',
            'linkedin'     => '/(?:https?:)\/\/(?:www\.)?linkedin\.com\/(?:in|company)\/[a-zA-Z0-9-_@]+/m',
            'marketsquare' => '/(?:https?:)\/\/(?:www\.)?marketsquare\.io\/(users|projects)\/[a-zA-Z0-9-_@]+/m',
            'medium'       => '/(?:https?:)\/\/((?:www\.)?medium\.com\/(?:u\/|@)?(?P<username>[a-zA-Z0-9-_@]+)|((?P<subdomain>[a-zA-Z0-9-]+)\.medium\.com))(?:\?.*)?/m',
            'peakd'        => '/(?:https?:)\/\/(?:www\.)?peakd\.com\/(@[a-zA-Z0-9-_@])/m',
            'reddit'       => '/(?:https?:)\/\/(?:[a-zA-Z0-9-_@]+\.)?reddit\.com\/(?:r)|(?:u(?:ser)?)\/(?P<username>[A-z0-9\-\_]*)\/?/m',
            'slack'        => '/(?:https?:)\/\/(?:[a-zA-Z0-9-_@]+\.)?slack\.com\/?/m',
            'telegram'     => '/(?:https?:)\/\/(?:t(?:elegram)?\.me|telegram\.org)\/(?P<username>[a-zA-Z0-9-_@]{5,32})\/?/m',
            'twitter'      => '/(?:https?:)\/\/(?:www\.)?twitter\.com\/(#!\/)?(?<username>[a-zA-Z0-9-_@]+)+/m',
            'weibo'        => '/(?:https?:)\/\/(?:[a-zA-Z0-9-_@]+\.)?weibo\.(com)\/[a-zA-Z0-9]+/m',
            'youtube'      => '/(?:https?:)\/\/((?:www|m)\.)?((?:youtube\.(com?|[a-z]*)(?:\.[a-zA-z]{2})?|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\\\\-]+)(.*)?$/m',
        ],

        'social_media_name' => [
            'twitter' => '/^[a-zA-Z0-9-_@]+$/m',
        ],

        'source_providers' => [
            'bitbucket' => '/(?:https?:)\/\/(?:www\.)?bitbucket\.(com|org)\/(?P<login>[A-z0-9_-]+)(?:\/(?P<repo>[*]+)\/?)?/m',
            'github'    => '/(?:https?:)\/\/(?:www\.)?github\.com\/(?P<login>[A-z0-9_-]+)(?:\/(?P<repo>[*]+)\/?)?/m',
            'gitlab'    => '/(?:https?:)\/\/(?:www\.)?gitlab\.com\/(?P<login>[A-z0-9_-]+)(?:\/(?P<repo>[*]+)\/?)?/m',
        ],

        'video_sources' => [
            'youtube' => '/(?:https?:)\/\/((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/m',
        ],

        'user_mentions' => '/<a[^>]*data-username="([^"]*)"[^>]*>([^<]+)<\/a>/',

        'website' => '/https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.(?<host>[^\s]{1,})/m',

        'www_url_prefix' => '/^www\./',
    ],

];
