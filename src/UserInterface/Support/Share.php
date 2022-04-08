<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support;

final class Share
{
    public static function facebook(?string $url = null, ?string $title = null): string
    {
        return static::shareUrl('facebook', $url, $title);
    }

    public static function twitter(?string $url = null, ?string $title = null): string
    {
        return static::shareUrl('twitter', $url, $title);
    }

    public static function reddit(?string $url = null, ?string $title = null): string
    {
        return static::shareUrl('reddit', $url, $title);
    }

    private static function shareUrl(string $service, ?string $url = null, ?string $title = null): string
    {
        if ($url === '') {
            $url = Request::url();
        }

        $base = config('share.services.'.$service.'.uri');

        return urldecode($base.'?'.http_build_query([
            'title' => urlencode($title ?? config('share.services.reddit.text')),
            'url'   => $url,
        ]));
    }
}
