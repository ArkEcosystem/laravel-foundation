<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\Article;
use Illuminate\Support\Facades\Route;

it('should render blog', function () {
    $this->get(route('blog'))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.index')
        ->assertViewHas('request');
});

it('can render an article page', function () {
    $article = Article::factory()->create();

    $this->get(route('article', $article))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.article')
        ->assertViewHas('article', fn ($a) => $a->is($article))
        ->assertViewHas('articles', fn ($articles) => $articles->isEmpty());

    $twoRelatedArticles = Article::factory()->times(2)->create();

    $this->get(route('article', $article))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.article')
        ->assertViewHas('article', fn ($a) => $a->is($article))
        ->assertViewHas('articles', fn ($articles) => $articles->count() === 2 && ! $articles->contains($article));

    $twoMoreRelatedArticles = Article::factory()->times(2)->create();

    $this->get(route('article', $article))
            ->assertOk()
            ->assertViewIs('ark::pages.blog.article')
            ->assertViewHas('article', fn ($a) => $a->is($article))
            ->assertViewHas('articles', fn ($articles) => $articles->count() === 3 && ! $articles->contains($article));
});

test('users cannot access draft articles', function () {
    Route::view('/home', 'layouts.app')->name('home');
    Route::view('/contact', 'layouts.app')->name('contact');

    $article = Article::factory()->create([
        'published_at' => null,
    ]);

    $this->get(route('article', $article))->assertNotFound();

    $article = Article::factory()->create([
        'published_at' => now()->addDays(5),
    ]);

    $this->get(route('article', $article))->assertNotFound();
});
