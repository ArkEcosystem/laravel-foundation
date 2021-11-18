<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Support\TransformDotsInUrlsInvisibly;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class StringMacroServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Str::macro('transformDotsInUrlsInvisibly', function ($str): string {
            return (new TransformDotsInUrlsInvisibly($str))->getString();
        });
    }
}
