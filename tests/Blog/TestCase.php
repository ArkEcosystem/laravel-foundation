<?php

declare(strict_types=1);

namespace Tests\Blog;

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Fortify\Http\Middleware\EnforceTwoFactorAuthentication;
use ARKEcosystem\Foundation\Providers\BlogServiceProvider;
use ARKEcosystem\Foundation\Providers\FortifyServiceProvider;
use ARKEcosystem\Foundation\Providers\HermesServiceProvider;
use ARKEcosystem\Foundation\Providers\MarkdownServiceProvider;
use ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;
use Livewire\LivewireServiceProvider;
use JamesMills\LaravelTimezone\LaravelTimezoneServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\ResponseCache\ResponseCacheServiceProvider;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;
use Tests\TestCase as Base;

/**
 * @coversNothing
 */
class TestCase extends Base
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMix();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function defineEnvironment($app)
    {
        parent::defineEnvironment($app);

        $app->router->aliasMiddleware('doNotCacheResponse', DoNotCacheResponse::class);
        $app->router->aliasMiddleware('two-factor', EnforceTwoFactorAuthentication::class);

        $app->booting(function () {
            AliasLoader::getInstance()->alias('BlogCategory', Category::class);
        });

        View::addLocation(realpath(__DIR__.'/blade-views'));
    }

    protected function getPackageProviders($app)
    {
        return [
            // First-Party
            BlogServiceProvider::class,
            MarkdownServiceProvider::class,
            UserInterfaceServiceProvider::class,

            // Third-Party
            LivewireServiceProvider::class,
            MediaLibraryServiceProvider::class,
            ResponseCacheServiceProvider::class,
            LaravelTimezoneServiceProvider::class,
        ];
    }
}
