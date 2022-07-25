<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Components\Kiosk\UpdateArticle;
use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('updates the article', function () {
    $article = Article::factory()->create();

    Storage::fake('public');

    $banner = File::image('dummy-banner.jpg');

    expect($article->banner())->toBe('/images/vendor/ark/article/placeholder-banner.png');

    Livewire::actingAs($article->author)
            ->test(UpdateArticle::class, ['article' => $article])
            ->assertSet('state.title', $article->title)
            ->set('state.banner', $banner)
            ->set('state.title', 'Hello World')
            ->call('save')
            ->assertSet('state.title', 'Hello World');

    $article->refresh();

    expect($article->title)->toBe('Hello World');
    expect($article->slug)->toBe('hello-world');
    expect($article->banner())->not->toBe('/images/vendor/ark/article/placeholder-banner.png');
});

it('updates the draft article', function () {
    $article = Article::factory()->create();

    Storage::fake('public');

    $banner = File::image('dummy-banner.jpg');

    expect($article->banner())->toBe('/images/vendor/ark/article/placeholder-banner.png');

    Livewire::actingAs($article->author)
            ->test(UpdateArticle::class, ['article' => $article])
            ->assertSet('state.title', $article->title)
            ->set('state.banner', $banner)
            ->set('state.title', 'Hello World')
            ->set('state.published_at', '')
            ->call('save')
            ->assertSet('state.title', 'Hello World');

    $article->refresh();

    expect($article->title)->toBe('Hello World');
    expect($article->slug)->toBe('hello-world');
    expect($article->published_at)->toBeNull();
    expect($article->banner())->not->toBe('/images/vendor/ark/article/placeholder-banner.png');
});
