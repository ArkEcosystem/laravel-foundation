<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

final class TwitterRenderer
{
    public static function render(MediaUrl $url): string
    {
        $url = 'https://twitter.com/'.$url->getId();

        $darkModeEnabled = Config::get('ui.dark-mode.enabled', false);

        $result = sprintf(
            $darkModeEnabled ? '<div class="dark:hidden">%s</div>' : '%s',
            Cache::rememberForever(md5($url), function () use ($url, $darkModeEnabled) {
                try {
                    $response = Http::get('https://publish.twitter.com/oembed', [
                        'url'         => $url,
                        'hide_thread' => 1,
                        'hide_media'  => 0,
                        'omit_script' => true,
                        'dnt'         => true,
                        'limit'       => 20,
                        'chrome'      => 'nofooter',
                    ])->json();

                    return Arr::get($response, 'html', '');
                } catch (ConnectionException $e) {
                    return false;
                }
            })
        );

        if ($darkModeEnabled) {
            $result .= sprintf(
                $darkModeEnabled ? '<div class="hidden dark:block">%s</div>' : '%s',
                Cache::rememberForever(md5($url).':dark', function () use ($url) {
                    try {
                        $response = Http::get('https://publish.twitter.com/oembed', [
                            'url'         => $url,
                            'hide_thread' => 1,
                            'hide_media'  => 0,
                            'omit_script' => true,
                            'dnt'         => true,
                            'limit'       => 20,
                            'chrome'      => 'nofooter',
                            'theme'       => 'dark',
                        ])->json();

                        return Arr::get($response, 'html', '');
                    } catch (ConnectionException $e) {
                        return false;
                    }
                })
            );
        }

        // If the result is `false`, means we had a connection error
        // (publish.twitter.com is down) in that case the results should not be
        // cached forever. We'll cache the result for 5 minutes.
        if ($result === false) {
            Cache::forget(md5($url));

            return Cache::remember(md5($url), now()->addMinutes(5), fn () => '');
        }

        return $result;
    }
}
