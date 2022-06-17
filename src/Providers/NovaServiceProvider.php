<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Fortify\Nova\Permission as NovaPermission;
use ARKEcosystem\Foundation\Fortify\Nova\Role as NovaRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\ActionResource;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Resource;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    public static function resourcesIn(string $directory): void
    {
        $resources = [];

        foreach ((new Finder())->in($directory)->files() as $file) {
            /** @var string $resource */
            $resource = 'App\\Nova\\'.ucfirst(Str::replaceLast('.php', '', $file->getRelativePathname()));

            if (is_subclass_of($resource, Resource::class) &&
                ! (new ReflectionClass($resource))->isAbstract() &&
                ! (is_subclass_of($resource, ActionResource::class))) {
                $resources[] = $resource;
            }
        }

        Nova::resources(collect($resources)->sort()->all());
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Route::namespace('Laravel\Nova\Http\Controllers')
            ->domain(config('nova.domain', null))
            ->middleware(config('nova.middleware', []))
            ->prefix(Nova::path())
            ->group(fn () => Route::get('/logout', 'LoginController@logout')->name('nova.logout'));

        Nova::routes()->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', fn ($user): bool => $user->canModerate());
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards(): array
    {
        return [];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards(): array
    {
        return [];
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        self::resourcesIn(app_path('Nova'));

        // TODO: enable when https://github.com/vyuldashev/nova-permission merges in support for Nova v4...
        if (! str_starts_with(Nova::version(), '4.')) {
            Nova::resources([
                NovaPermission::class,
                NovaRole::class,
            ]);
        }
    }
}
