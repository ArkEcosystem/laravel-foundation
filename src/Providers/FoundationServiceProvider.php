<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Third-Party
        $this->app->register(MarkdownServiceProvider::class);
        $this->app->register(LaravelFortifyServiceProvider::class);

        // First-Party
        $this->app->register(StanServiceProvider::class);
        $this->app->register(CommonMarkServiceProvider::class);
        $this->app->register(HermesServiceProvider::class);
        $this->app->register(RulesServiceProvider::class);
        $this->app->register(UserInterfaceServiceProvider::class);
        $this->app->register(StringMacroServiceProvider::class);
    }
}
