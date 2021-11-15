<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Support\TransformUrlsInvisibly;
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
        // This macro is depreciated in favor of Str::transformUrlsInvisibly().
        // As soon as it is not being used anymore, it can be deleted.
        Str::macro('wrapUrlsInBlankATag', function ($str, $attributes = []): string {
            $wrapper = new UrlInStringWrapper($str);
            $wrapper->setAttributes($attributes);

            return $wrapper->getString();
        });

        Str::macro('transformUrlsInvisibly', function ($str): string {
            return (new TransformUrlsInvisibly($str))->getString();
        });
    }
}
