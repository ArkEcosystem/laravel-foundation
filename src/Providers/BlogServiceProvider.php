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
use ARKEcosystem\Foundation\Blog\Controllers\KioskController;
use ARKEcosystem\Foundation\Blog\Controllers\UserController;
use ARKEcosystem\Foundation\Blog\Controllers\Contracts\ArticleController as ArticleControllerContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishers();

        $this->registerContracts();

        $this->registerBladeComponents();

        $this->registerLivewireComponents();

        $this->registerRoutes();
    }

    private function registerPublishers(): void
    {
        $this->publishes([
            __DIR__.'/../../config/blog.php' => config_path('blog.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../database/migrations/blog' => database_path('migrations'),
        ], 'blog-migrations');
    }

    protected function registerContracts(): void
    {
        $this->app->singleton(ArticleControllerContract::class, ArticleController::class);
    }

    private function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->component('ark::components.blog.article-content', 'ark-blog.article-content');
            $blade->component('ark::components.blog.author-header', 'ark-blog.author-header');
            $blade->component('ark::components.blog.category-badge', 'ark-blog.category-badge');
            $blade->component('ark::components.blog.blog-entry', 'ark-blog.blog-entry');
            $blade->component('ark::components.blog.header', 'ark-blog.header');
            $blade->component('ark::components.blog.placeholder-article-entry', 'ark-blog.placeholder-article-entry');
            $blade->component('ark::components.blog.related-article-entry', 'ark-blog.related-article-entry');
            $blade->component('ark::components.blog.related-articles', 'ark-blog.related-articles');
            $blade->component('ark::components.blog.sort', 'ark-blog.sort');
            $blade->component('ark::components.blog.search-input', 'ark-blog.search-input');
            $blade->component('ark::components.blog.filter-dropdown', 'ark-blog.filter-dropdown');
        });
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
                Route::middleware(['auth', 'two-factor'])->group(function () {
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
}
