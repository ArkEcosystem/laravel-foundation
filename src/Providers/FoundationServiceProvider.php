<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(UserInterfaceServiceProvider::class);
        $this->app->register(MarkdownServiceProvider::class);
        $this->app->register(CommonMarkServiceProvider::class);
        $this->app->register(HermesServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(StanServiceProvider::class);
    }
}
