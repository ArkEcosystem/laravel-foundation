<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Components\ArticleList;
use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use Livewire\Livewire;

it('sets initial state when mounted', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::test(ArticleList::class)
            ->assertSet('categories', [Category::News->value, Category::Editorials->value, Category::Updates->value, Category::Tutorials->value])
            ->assertSet('sortDirection', 'desc')
            ->assertSet('term', '')
            ->assertSet('searchCategories', [
                Category::Editorials->value => false,
                Category::News->value       => false,
                Category::Updates->value    => false,
                Category::Tutorials->value  => false,
            ])
            ->assertSet('pendingCategories', [
                Category::Editorials->value => false,
                Category::News->value       => false,
                Category::Updates->value    => false,
                Category::Tutorials->value  => false,
            ]);
});

it('sets search term based on the query parameter when mounted', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::withQueryParams(['q' => 'test'])
            ->test(ArticleList::class)
            ->assertSet('term', 'test');

    Livewire::withQueryParams(['q' => ''])
            ->test(ArticleList::class)
            ->assertSet('term', '');
});

it('sets sort direction based on the query parameter when mounted', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::withQueryParams(['order' => 'asc'])
            ->test(ArticleList::class)
            ->assertSet('sortDirection', 'asc');

    Livewire::withQueryParams(['order' => 'desc'])
            ->test(ArticleList::class)
            ->assertSet('sortDirection', 'desc');

    Livewire::withQueryParams(['order' => 'invalid'])
            ->test(ArticleList::class)
            ->assertSet('sortDirection', 'desc')
            ->call('sort')
            ->assertSet('sortDirection', 'asc')
            ->set('page', 2)
            ->call('sort')
            ->assertSet('sortDirection', 'desc')
            ->assertSet('page', 1);
});

it('can apply filter', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::test(ArticleList::class)
            ->set('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->set('searchCategories', [
                Category::Editorials->value      => false,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->set('page', 2)
            ->call('applyFilter')
            ->assertSet('page', 1)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);
});

it('can reset filter', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::test(ArticleList::class)
            ->set('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => true,
                Category::Tutorials->value       => false,
            ])
            ->set('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => true,
                Category::Tutorials->value       => false,
            ])
            ->set('page', 2)
            ->call('resetFilter')
            ->assertSet('page', 1)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => false,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => false,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);
});

it('sets active categories based on the query parameter when mounted', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Article::factory()->create([
        'category' => Category::News,
    ]);

    Livewire::withQueryParams(['category' => Category::Editorials->value])
            ->test(ArticleList::class)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);

    Livewire::withQueryParams(['category' => 'editorials,news'])
            ->test(ArticleList::class)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => true,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => true,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);

    Livewire::withQueryParams(['category' => 'news,editorials'])
            ->test(ArticleList::class)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => true,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => true,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);

    Livewire::withQueryParams(['category' => 'editorials,unknown'])
            ->test(ArticleList::class)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);

    Livewire::withQueryParams(['category' => 'unknown'])
            ->test(ArticleList::class)
            ->assertSet('pendingCategories', [
                Category::Editorials->value      => false,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertSet('searchCategories', [
                Category::Editorials->value      => false,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ]);
});

it('resets the page when search term changes', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::withQueryParams(['page' => 3, 'q' => 'hello'])
            ->test(ArticleList::class)
            ->assertSet('page', 3)
            ->assertSet('term', 'hello')
            ->set('term', 'something-else')
            ->assertSet('page', 1)
            ->assertDispatched('pageChanged');
});

it('resets the page when order changes', function () {
    Article::factory()->create([
        'category' => Category::Editorials,
    ]);

    Livewire::withQueryParams(['page' => 3, 'order' => 'asc'])
            ->test(ArticleList::class)
            ->assertSet('page', 3)
            ->assertSet('sortDirection', 'asc')
            ->call('sort')
            ->assertSet('page', 1)
            ->assertSet('sortDirection', 'desc')
            ->assertDispatched('pageChanged');
});

it('can search articles', function () {
    $article = Article::factory()->create([
        'body'         => 'Hello world',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(10),
    ]);

    Article::factory()->create([
        'body'         => 'Dummy',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(5),
    ]);

    Article::factory()->create([
        'body'         => 'Featured',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(3),
    ]);

    Livewire::test(ArticleList::class)
            ->set('term', 'World')
            ->assertViewHas('articles', function ($paginator) use ($article) {
                $articles = $paginator->getCollection();

                return $articles->count() === 1 && $articles->contains($article);
            });
});

it('can filter articles by category', function () {
    $article = Article::factory()->create([
        'body'         => 'Hello World',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(10),
    ]);

    Article::factory()->create([
        'body'         => 'Dummy',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(5),
    ]);

    Article::factory()->create([
        'body'         => 'Featured',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(3),
    ]);

    Livewire::test(ArticleList::class)
            ->set('searchCategories', [
                Category::Editorials->value      => true,
                Category::News->value            => false,
                Category::Updates->value         => false,
                Category::Tutorials->value       => false,
            ])
            ->assertViewHas('articles', function ($paginator) use ($article) {
                $articles = $paginator->getCollection();

                return $articles->count() === 1 && $articles->contains($article);
            });
});

it('does not include featured article in the list', function () {
    Article::factory()->create([
        'body'         => 'Hello World',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(10),
    ]);

    Article::factory()->create([
        'body'         => 'Dummy',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(5),
    ]);

    $featured = Article::factory()->create([
        'body'         => 'Featured',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(3),
    ]);

    Livewire::test(ArticleList::class)
            ->assertViewHas('articles', function ($paginator) use ($featured) {
                $articles = $paginator->getCollection();

                return $articles->count() === 2 && ! $articles->contains($featured);
            });
});

it('only includes published articles when rendering article list', function () {
    $article = Article::factory()->create([
        'body'         => 'Hello World',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(10),
    ]);

    Article::factory()->create([
        'body'         => 'Dummy',
        'category'     => Category::News,
        'published_at' => null,
    ]);

    Article::factory()->create([
        'body'         => 'Featured',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(3),
    ]);

    Livewire::test(ArticleList::class)
            ->assertViewHas('articles', function ($paginator) use ($article) {
                $articles = $paginator->getCollection();

                return $articles->count() === 1 && $articles->contains($article);
            });
});

it('orders by published date', function () {
    $older = Article::factory()->create([
        'body'         => 'Hello World',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(10),
    ]);

    $newer = Article::factory()->create([
        'body'         => 'Dummy',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(5),
    ]);

    $featured = Article::factory()->create([
        'body'         => 'Featured',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(3),
    ]);

    Livewire::withQueryParams(['order' => 'desc'])
            ->test(ArticleList::class)
            ->assertViewHas('articles', function ($paginator) use ($older, $newer, $featured) {
                $articles = $paginator->getCollection();

                return $articles->count() === 2
                    && ! $articles->contains($featured)
                    && $articles->modelKeys() === [$newer->id, $older->id];
            });

    Livewire::withQueryParams(['order' => 'asc'])
            ->test(ArticleList::class)
            ->assertViewHas('articles', function ($paginator) use ($older, $newer, $featured) {
                $articles = $paginator->getCollection();

                return $articles->count() === 2
                    && ! $articles->contains($featured)
                    && $articles->modelKeys() === [$older->id, $newer->id];
            });
});

it('paginates articles', function () {
    Article::factory()->create([
        'body'         => 'Hello World',
        'category'     => Category::Editorials,
        'published_at' => now()->subMinutes(10),
    ]);

    Article::factory()->create([
        'body'         => 'Dummy',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(5),
    ]);

    Article::factory()->create([
        'body'         => 'Featured',
        'category'     => Category::News,
        'published_at' => now()->subMinutes(3),
    ]);

    Livewire::test(ArticleList::class)
            ->assertViewHas('articles', function ($paginator) {
                return $paginator->total() === 2
                    && $paginator->perPage() === ArticleList::PER_PAGE;
            });
});
