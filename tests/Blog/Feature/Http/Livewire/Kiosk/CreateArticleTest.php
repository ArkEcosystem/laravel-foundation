<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Components\Kiosk\CreateArticle;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('creates the article', function () {
    Storage::fake('public');

    $banner = File::image('dummy-banner.jpg');

    Livewire::actingAs($user = User::factory()->create())
            ->test(CreateArticle::class)
            ->set('state', [
                'user_id'      => $user->id,
                'title'        => 'Hello World',
                'body'         => 'Hello World',
                'category'     => Category::News->value,
                'published_at' => '2020-01-01',
            ])
            ->set('state.banner', $banner)
            ->call('save')
            ->assertSet('state.title', 'Hello World');

    $article = Article::first();

    expect($article->author->is($user))->toBeTrue();
    expect($article->title)->toBe('Hello World');
    expect($article->slug)->toBe('hello-world');
    expect($article->banner())->not->toBe('/images/article/placeholder-banner.png');
});

it('creates the draft article', function () {
    Storage::fake('public');

    $banner = File::image('dummy-banner.jpg');

    Livewire::actingAs($user = User::factory()->create())
            ->test(CreateArticle::class)
            ->set('state', [
                'user_id'      => $user->id,
                'title'        => 'Hello World',
                'body'         => 'Hello World',
                'category'     => Category::News->value,
                'published_at' => '',
            ])
            ->set('state.banner', $banner)
            ->call('save')
            ->assertSet('state.title', 'Hello World');

    $article = Article::first();

    expect($article->author->is($user))->toBeTrue();
    expect($article->title)->toBe('Hello World');
    expect($article->slug)->toBe('hello-world');
    expect($article->published_at)->toBeNull();
    expect($article->banner())->not->toBe('/images/article/placeholder-banner.png');
});
