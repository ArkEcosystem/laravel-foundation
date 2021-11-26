<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support;

final class Share
{
    public static function facebook(string $url, ?string $title = null): string
    {
        $base = config('share.services.facebook.uri');

        return self::buildLink($base, [
            'u' => $url,
        ]);
    }

    public static function twitter(string $url, ?string $title = null): string
    {
        $base = config('share.services.twitter.uri');

        return self::buildLink($base, [
            'text' => urlencode($title ?? config('share.services.twitter.text')),
            'url'  => $url,
        ]);
    }

    public static function reddit(string $url, ?string $title = null): string
    {
        $base = config('share.services.reddit.uri');

        return self::buildLink($base, [
            'title' => urlencode($title ?? config('share.services.reddit.text')),
            'url'   => $url,
        ]);
    }

    private static function buildLink(string $url, array $option): string
    {
        return urldecode($url.'?'.http_build_query($option));
    }
}
