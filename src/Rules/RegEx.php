<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Rules;

use Exception;
use Illuminate\Support\Arr;

final class RegEx
{
    public static function get(string $rule): string
    {
        return config("rules.regex.$rule");
    }

    public static function socialMediaLink(string $service): string
    {
        if (! array_key_exists($service, config('rules.regex.social_media_link'))) {
            throw new Exception("Invalid social media link provided [{$service}]");
        }

        return config("rules.regex.social_media_link.$service");
    }

    public static function socialMediaName(string $service): string
    {
        if (! array_key_exists($service, config('rules.regex.social_media_name'))) {
            throw new Exception("Invalid social media name provided [{$service}]");
        }

        return config("rules.regex.social_media_name.$service");
    }

    public static function sourceProviderLink(string $service): string
    {
        if (! array_key_exists($service, config('rules.regex.source_providers'))) {
            throw new Exception("Invalid source provided [{$service}]");
        }

        return config("rules.regex.source_providers.$service");
    }

    public static function videoSource(string $service, string $source): bool
    {
        if ($service === 'youtube') {
            return self::validateYoutubeURL($source);
        }

        return false;
    }

    private static function validateYoutubeURL(string $source): bool
    {
        return preg_match(config('rules.regex.video_sources.youtube'), $source, $matches) === 1;
    }

    public static function getTwitterUsername(string $source): ? string
    {
        preg_match(config('rules.regex.social_media_link.twitter'), $source, $matches);

        return Arr::get($matches, 'username');
    }

    /**
     * Extracts the domain from the given hostname, ignoring prefedined
     * subdomains such as www
     * e.g. `www.ark.io` will return `ark.io` but `learn.ark.io`
     * will return `learn.ark.io`.
     */
    public static function getDomainFromHost(string $host): ? string
    {
        return preg_replace(config('rules.regex.www_url_prefix'), '', $host);
    }
}
