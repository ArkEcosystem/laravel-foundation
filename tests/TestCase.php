<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Foundation\Providers\CommonMarkServiceProvider;
use ARKEcosystem\Foundation\Providers\FortifyServiceProvider;
use ARKEcosystem\Foundation\Providers\HermesServiceProvider;
use ARKEcosystem\Foundation\Providers\MarkdownServiceProvider;
use ARKEcosystem\Foundation\Providers\RulesServiceProvider;
use ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Support\Facades\View;
use Illuminate\Testing\TestView;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Honeypot\HoneypotServiceProvider;
use Spatie\Newsletter\NewsletterServiceProvider;

/**
 * @coversNothing
 */
class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->registerMacros();
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('markdown', [
            'inlineRenderers' => [],
        ]);

        $app['config']->set('app.url', 'https://ourapp.com');
        $app['config']->set('view.paths', [
            realpath(__DIR__.'/../resources/views'),
            realpath(__DIR__.'/blade-views'),
        ]);

        View::addNamespace('ark', realpath(__DIR__.'/../resources/views'));
        View::addLocation(realpath(__DIR__.'/blade-views'));

        $this->withViewErrors([
            //
        ]);
    }

    protected function registerMacros() : void
    {
        TestView::macro('assertSeeHtml', function ($value) {
            /** @var TestView $this */
            return $this->assertSee($value, escape: false);
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            // Third-Party
            LaravelFortifyServiceProvider::class,
            MarkdownServiceProvider::class,
            LivewireServiceProvider::class,
            HoneypotServiceProvider::class,
            // First-Party
            FortifyServiceProvider::class,
            HermesServiceProvider::class,
            NewsletterServiceProvider::class,
            RulesServiceProvider::class,
            UserInterfaceServiceProvider::class,
            // CommonMarkServiceProvider::class, // TODO: custom finder from this causes component tests to fail
        ];
    }

    protected function resolveApplicationExceptionHandler($app)
    {
        $app->singleton('Illuminate\Contracts\Debug\ExceptionHandler', \Tests\Stubs\ExceptionHandler::class);
    }
}
