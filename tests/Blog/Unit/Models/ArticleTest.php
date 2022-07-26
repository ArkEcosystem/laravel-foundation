<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\ResponseCache;

it('can get featured article', function () {
    $article = Article::factory()->create([
        'title'         => 'Hello World',
        'published_at'  => now()->subMinutes(30),
    ]);

    $featured = Article::factory()->create([
        'title'         => 'Hello World',
        'published_at'  => now()->subMinutes(3), // newer...
    ]);

    $null = Article::factory()->create([
        'title'         => 'Hello World',
        'published_at'  => null,
    ]);

    expect(Article::featured()->is($featured))->toBeTrue();
});

it('has a banner photo', function () {
    $article = Article::factory()->create([
        'slug' => 'dummy-article',
    ]);

    expect($article->banner())->toBe('/images/vendor/ark/article/placeholder-banner.png');

    Storage::fake('public');

    $article->addMedia(
        File::image('dummy-banner.jpg')
    )->toMediaCollection('banner');

    expect($article->fresh()->banner())->toMatch('/^\/storage\/[0-9]+\/dummy-banner\.jpg$/');
});

it('generate share URLs', function () {
    $article = Article::factory()->create([
        'title' => 'Dummy Article',
        'slug'  => 'dummy-article',
    ]);

    expect($article->shareUrlReddit())->toBe('https://www.reddit.com/submit?title=Dummy+Article&url='.$article->url());
    expect($article->shareUrlFacebook())->toBe('https://www.facebook.com/sharer/sharer.php?u='.$article->url());
    expect($article->shareUrlTwitter())->toBe('https://twitter.com/intent/tweet?text=Dummy+Article&url='.$article->url());
});

it('can generate excerpt', function () {
    expect((new Article([
        'body' => 'This is a very long text that contains more than 5 words.',
    ]))->excerpt(5))->toBe('This is a very long...');

    expect((new Article([
        'body' => 'This is a **very** long text that contains more than 5 words.',
    ]))->excerpt(5))->toBe('This is a very long...');

    expect((new Article([
        'body' => 'Short text.',
    ]))->excerpt(5))->toBe('Short text.');
});

it('can search articles', function () {
    $article = Article::factory()->create([
        'title'     => 'Dummy Article',
        'slug'      => 'dummy-article',
        'body'      => 'Hello world.',
        'category'  => Category::News,
    ]);

    Article::factory()->create([
        'title'     => 'Unknown Article',
        'slug'      => 'dummy-article-2',
        'body'      => 'Something else.',
        'category'  => Category::Updates,
    ]);

    // Title...
    $articles = Article::search('dummy')->get();
    expect($articles)->toHaveCount(1);
    expect($articles->contains($article))->toBeTrue();

    // Body...
    $articles = Article::search('Hello')->get();
    expect($articles)->toHaveCount(1);
    expect($articles->contains($article))->toBeTrue();

    // Category...
    $articles = Article::search('news')->get();
    expect($articles)->toHaveCount(1);
    expect($articles->contains($article))->toBeTrue();
});

it('has an author', function () {
    $author = User::factory()->create();

    $article = Article::factory()->create([
        'user_id' => $author->id,
        'slug'    => 'dummy-article',
    ]);

    expect($article->author->is($author))->toBeTrue();
});

it('can get reading time', function () {
    $article = Article::factory()->create([
        'body' => 'This is some hello world text.',
    ]);

    expect($article->reading_time)->toBe(1);
});

it('can determine if article is published or not', function () {
    expect((new Article([
        'published_at' => now(),
    ]))->isPublished())->toBeTrue();

    expect((new Article([
        'published_at' => null,
    ]))->isPublished())->toBeFalse();

    expect((new Article([
        'published_at' => now()->addMinutes(3),
    ]))->isPublished())->toBeFalse();

    expect((new Article([
        'published_at' => now()->subDay(),
    ]))->isPublished())->toBeTrue();
});

it('can get article with deleted author', function () {
    $author  = User::factory()->create();
    $article = Article::factory()->create(['user_id' => $author->id]);

    $author->delete();

    $this->assertDatabaseHas('users', [
        'id'         => $author->id,
        'deleted_at' => $author->deleted_at,
    ]);

    $article = Article::where('slug', $article->slug)->first();

    expect($article)->not->toBeNull();
    expect($article->deleted_at)->toBeNull();
    expect($article->author->deleted_at)->not->toBeNull();
});

it('clears response cache on create', function () {
    $this->mock(ResponseCache::class)
        ->shouldReceive('clear')
        ->once();

    $article = Article::factory()->create();
});

it('clears response cache on update', function () {
    $this->mock(ResponseCache::class)
        ->shouldReceive('clear')
        ->twice();

    $article = Article::factory()->create();

    $article->published_at = Carbon::now();
    $article->save();
});

it('clears response cache on delete', function () {
    $this->mock(ResponseCache::class)
        ->shouldReceive('clear')
        ->times(3);

    $article = Article::factory()->create();

    $article->published_at = Carbon::now();
    $article->save();
    $article->delete();
});
