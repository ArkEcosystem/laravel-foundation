<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;

it('can render kiosk', function () {
    $article = Article::factory()->create();

    $response = $this->actingAs(User::factory()->create(['two_factor_secret' => 'code']))
        ->get(route('kiosk.articles'))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.kiosk.articles');
});

it('can render an article page', function () {
    $article = Article::factory()->create();

    $this->actingAs(User::factory()->create(['two_factor_secret' => 'code']))
        ->get(route('kiosk.article', $article))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.kiosk.article')
        ->assertViewHas('article', fn ($a) => $a->is($article));
});

it('can render a page for creating a new article', function () {
    $this->actingAs(User::factory()->create(['two_factor_secret' => 'code']))
        ->get(route('kiosk.articles.create'))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.kiosk.articles.create');
});
