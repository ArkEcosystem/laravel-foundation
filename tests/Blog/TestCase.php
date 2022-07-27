<?php

declare(strict_types=1);

namespace Tests\Blog;

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Fortify\Http\Middleware\EnforceTwoFactorAuthentication;
use ARKEcosystem\Foundation\Providers\BlogServiceProvider;
use ARKEcosystem\Foundation\Providers\MarkdownServiceProvider;
use ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use JamesMills\LaravelTimezone\LaravelTimezoneServiceProvider;
use Livewire\LivewireServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;
use Spatie\ResponseCache\ResponseCacheServiceProvider;
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
        $this->loadMigrationsFrom(dirname(__DIR__).'/database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function defineEnvironment($app)
    {
        parent::defineEnvironment($app);

        $app->router->aliasMiddleware('doNotCacheResponse', DoNotCacheResponse::class);
        $app->router->aliasMiddleware('two-factor', EnforceTwoFactorAuthentication::class);

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

    protected function getPackageAliases($app)
    {
        return [
            'BlogCategory' => Category::class,
        ];
    }
}
