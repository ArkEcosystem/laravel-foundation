<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Blog\Components\ArticleList;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\Articles;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\CreateArticle;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\CreateUser;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\DeleteArticle;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\DeleteUser;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\UpdateArticle;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\UpdateUser;
use ARKEcosystem\Foundation\Blog\Controllers\ArticleController;
use ARKEcosystem\Foundation\Blog\Controllers\AuthorController;
use ARKEcosystem\Foundation\Blog\Controllers\Contracts\ArticleController as ArticleControllerContract;
use ARKEcosystem\Foundation\Blog\Controllers\KioskController;
use ARKEcosystem\Foundation\Blog\Controllers\UserController;
use ARKEcosystem\Foundation\Blog\Listeners\UpdateUserTimezone;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishers();

        $this->registerContracts();

        $this->registerLivewireComponents();

        $this->registerRoutes();

        $this->registerListeners();
    }

    protected function registerContracts(): void
    {
        $this->app->singleton(ArticleControllerContract::class, ArticleController::class);
    }

    private function registerPublishers(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views/pages/blog', 'blog');

        $this->publishes([
            __DIR__.'/../../config/blog.php' => config_path('blog.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../database/migrations/blog' => database_path('migrations'),
        ], 'blog-migrations');
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('blog-article-list', ArticleList::class);
        Livewire::component('kiosk-articles', Articles::class);
        Livewire::component('kiosk-create-article', CreateArticle::class);
        Livewire::component('kiosk-create-user', CreateUser::class);
        Livewire::component('kiosk-delete-article', DeleteArticle::class);
        Livewire::component('kiosk-delete-user', DeleteUser::class);
        Livewire::component('kiosk-update-article', UpdateArticle::class);
        Livewire::component('kiosk-update-user', UpdateUser::class);
    }

    private function registerRoutes(): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/blog', [resolve(ArticleControllerContract::class)::class, 'index'])->name('blog');
            Route::get('/blog/{article:slug}', [resolve(ArticleControllerContract::class)::class, 'show'])->name('article');
            Route::get('/authors/{author:name_slug}', AuthorController::class)->name('author');

            Route::middleware(['doNotCacheResponse'])->group(function () {
                Route::view('/kiosk', 'ark::pages.blog.kiosk.dashboard')->name('kiosk')->middleware('auth');
                Route::middleware(['auth'])->group(function () { //Route::middleware(['auth', 'two-factor'])->group(function () {
                    Route::get('/kiosk/articles', [KioskController::class, 'index'])->name('kiosk.articles');
                    Route::view('/kiosk/articles/create', 'ark::pages.blog.kiosk.articles.create')->name('kiosk.articles.create');
                    Route::get('/kiosk/articles/{article:slug}', [KioskController::class, 'show'])->name('kiosk.article');

                    Route::get('/kiosk/users', [UserController::class, 'index'])->name('kiosk.users');
                    Route::view('/kiosk/users/create', 'ark::pages.blog.kiosk.users.create')->name('kiosk.users.create');
                    Route::get('/kiosk/users/{user}', [UserController::class, 'edit'])->name('kiosk.user');
                });
            });
        });
    }

    private function registerListeners(): void
    {
        Event::listen(Login::class, UpdateUserTimezone::class);
    }
}
