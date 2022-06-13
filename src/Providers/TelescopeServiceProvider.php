<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as Telescope;

class TelescopeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(Telescope::class);
            $this->app->register(TelescopeApplicationServiceProvider::class);
        }
    }
}
