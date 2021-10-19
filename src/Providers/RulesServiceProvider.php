<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class RulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/rules.php' => config_path('rules.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/rules.php',
            'rules'
        );
    }
}
