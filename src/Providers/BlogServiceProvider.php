<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Blog\Controllers\ArticleController;
use ARKEcosystem\Foundation\Blog\Controllers\KioskController;
use ARKEcosystem\Foundation\Blog\Controllers\UserController;
use ARKEcosystem\Foundation\Blog\Components\ArticleList;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\Articles;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\CreateArticle;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\CreateUser;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\DeleteArticle;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\DeleteUser;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\UpdateArticle;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\UpdateUser;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerBladeComponents();

        $this->registerLivewireComponents();

        $this->registerRoutes();
    }

    private function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->component('ark::components.blog.article-content', 'ark-blog.article-content');
            $blade->component('ark::components.blog.blog-entry', 'ark-blog.blog-entry');
            $blade->component('ark::components.blog.header', 'ark-blog.header');
            $blade->component('ark::components.blog.placeholder-article-entry', 'ark-blog.placeholder-article-entry');
            $blade->component('ark::components.blog.related-article-entry', 'ark-blog.related-article-entry');
            $blade->component('ark::components.blog.related-articles', 'ark-blog.related-articles');
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
            Route::get('/blog', [ArticleController::class, 'index'])->name('blog');
            Route::get('/blog/{article:slug}', [ArticleController::class, 'show'])->name('article');

            Route::middleware(['doNotCacheResponse'])->group(function () {
                Route::view('/kiosk', 'ark::pages.blog.kiosk.dashboard')->name('kiosk')->middleware('auth');
                Route::middleware(['auth', 'two-factor'])->group(function() {
                    Route::get('/kiosk/articles', [KioskController::class, 'index'])->name('kiosk.articles');
                    Route::view('/kiosk/articles/create', 'ark::pages.blog.kiosk.articles.create')->name('kiosk.articles.create');
                    Route::get('/kiosk/articles/{article:slug}', [KioskController::class, 'show'])->name('kiosk.article');

                    Route::get('/kiosk/users', [UserController::class, 'index'])->name('kiosk.users');
                    Route::view('/kiosk/users/create', 'kiosk.users.create')->name('kiosk.users.create');
                    Route::get('/kiosk/users/{user}', [UserController::class, 'edit'])->name('kiosk.user');
                });
            });
        });
    }
}
