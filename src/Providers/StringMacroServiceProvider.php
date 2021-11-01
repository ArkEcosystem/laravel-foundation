<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Support\UrlInStringWrapper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class StringMacroServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Str::macro('wrapUrlsInBlankATag', function ($str, $attributes = []): string {
            $wrapper = new UrlInStringWrapper($str);
            $wrapper->setAttributes($attributes);

            return $wrapper->getString();
        });
    }
}
