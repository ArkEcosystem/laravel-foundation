<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class TwitterRenderer
{
    public static function render(MediaUrl $url): string
    {
        $url = 'https://twitter.com/'.$url->getId();

        $darkModeEnabled = config('ui.dark-mode.enabled', false);

        $darkEmbed = null;
        $embed     = self::getEmbed($url);
        $result    = sprintf(
            $darkModeEnabled ? '<div class="twitter-embed-wrapper">%s</div>' : '%s',
            $embed
        );

        if ($darkModeEnabled) {
            $darkEmbed = self::getEmbed($url, true);

            $result .= sprintf(
                '<div class="twitter-embed-wrapper twitter-embed-wrapper-dark">%s</div>',
                $darkEmbed
            );
        }

        // If the result is `false`, means we had a connection error
        // (publish.twitter.com is down) in that case the results should not be
        // cached forever. We'll cache the result for 5 minutes.
        if ($embed === null) {
            Cache::forget(md5($url));

            return Cache::remember(md5($url), now()->addMinutes(5), fn () => '');
        }

        if ($darkModeEnabled && $darkEmbed === null) {
            Cache::forget(md5($url).':dark');

            return Cache::remember(md5($url).':dark', now()->addMinutes(5), fn () => '');
        }

        return $result;
    }

    private static function getEmbed(string $url, bool $dark = false): ?string
    {
        $key = md5($url);
        if ($dark) {
            $key .= ':dark';
        }

        return Cache::rememberForever($key, function () use ($url, $dark) {
            $html       = null;
            $properties = [
                'url'         => $url,
                'hide_thread' => 1,
                'hide_media'  => 0,
                'omit_script' => true,
                'dnt'         => true,
                'limit'       => 20,
                'chrome'      => 'nofooter',
            ];

            if ($dark) {
                $properties['theme'] = 'dark';
            }

            try {
                $response = Http::get('https://publish.twitter.com/oembed', $properties)->json();

                $html = Arr::get($response, 'html', '');
            } catch (ConnectionException $e) {
                //
            }

            return $html;
        });
    }
}
