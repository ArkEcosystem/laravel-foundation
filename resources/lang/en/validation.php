<?php

declare(strict_types=1);

return [
    'custom'                           => [
        'max_markdown_chars' => 'The text may not be greater than :max characters.',
        'invalid_tag'        => 'Only letters and numbers are allowed, the tag must start with a letter and must be between 3 and 30 characters.',
    ],

    'extended-footer-contact'          => [
        'required' => 'This field is required.',
        'max'      => 'Please keep this field under :max characters.',
        'email'    => 'This field must be a valid e-mail address.',
    ],

    'tag'                              => [
        'special_character_start'        => 'The tag must start with a letter.',
        'special_character_end'          => 'The tag must end with a letter.',
        'consecutive_special_characters' => 'The tag must not contain consecutive special characters.',
        'min_length'                     => 'The tag must be between 3 and 30 characters.',
        'max_length'                     => 'The tag must be between 3 and 30 characters.',
        'lowercase_only'                 => 'The tag must be lowercased.',
        'forbidden_special_characters'   => 'The tag must only contain letters, numbers, spaces and -',
    ],

    // Fortify
    'password_doesnt_match'            => 'The provided password does not match your current password.',
    'password_doesnt_match_records'    => 'This password does not match our records.',
    'password_reset_link_invalid'      => 'Your password reset link expired or is invalid.',
    'password_leaked'                  => 'Your password appears to have been leaked.',
    'password_current'                 => 'You cannot use your existing password.',

    'messages'                         => [
        'one_time_password'           => 'We were not able to enable two-factor authentication with this one-time password.',
        'some_special_characters'     => "The :attribute can only contain letters, numbers and . & - , '",
        'include_letters'             => 'The :attribute needs at least one letter',
        'start_with_letter_or_number' => 'The :attribute must start with a letter or a number',
        'unique_case_insensitive'     => 'The :attribute has already been taken.',

        'username'                    => [
            'special_character_start'         => 'Username must not start or end with special characters',
            'special_character_end'           => 'Username must not start or end with special characters',
            'consecutive_special_characters'  => 'Username must not contain consecutive special characters',
            'forbidden_special_characters'    => 'Username must only contain letters, numbers and _ .',
            'max_length'                      => 'Username may not have more than :length characters.',
            'min_length'                      => 'Username must be at least :length characters.',
            'lowercase_only'                  => 'Username must be lowercase characters.',
            'blacklisted'                     => 'This :attribute is unavailable.',
        ],
    ],

    // Social Rules
    'social'                           => [
        'video'         => [
            'url' => 'The given video URL is not properly formatted. A valid URL must start with http[s]://',
        ],
        'website'       => [
            'url' => 'The given website URL is not properly formatted. A valid URL must start with http[s]://',
        ],
        'bitbucket_url' => 'The given URL is not a valid Bitbucket URL',
        'discord_url'   => 'The given URL is not a valid Discord URL',
        'facebook_url'  => 'The given URL is not a valid Facebook profile URL',
        'github_url'    => 'The given URL is not a valid Github URL',
        'gitlab_url'    => 'The given URL is not a valid Gitlab URL',
        'hive_url'      => 'The given URL is not a valid Hive URL',
        'instagram_url' => 'The given URL is not a valid Instagram URL',
        'linkedin_url'  => 'The given URL is not a valid LinkedIn profile URL',
        'medium_url'    => 'The given URL is not a valid medium profile URL',
        'reddit_url'    => 'The given URL is not a valid Reddit URL',
        'slack_url'     => 'The given URL is not a valid Slack URL',
        'telegram_url'  => 'The given URL is not a valid Telegram URL',
        'twitter_name'  => 'The given name is not a valid Twitter profile name',
        'twitter_url'   => 'The given URL is not a valid Twitter profile URL',
        'website_url'   => 'The given website URL is not properly formatted. A valid URL must start with http[s]://',
        'weibo_url'     => 'The given URL is not a valid Weibo URL',
        'youtube_url'   => 'The given URL is not a valid YouTube Channel URL',
        'looksrare_url' => 'The given URL is not a valid LooksRare URL',
        'opensea_url'   => 'The given URL is not a valid OpenSea URL',
        'tiktok_url'    => 'The given URL is not a valid TikTok URL',
    ],
];
