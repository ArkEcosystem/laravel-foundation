<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Components\Kiosk\DeleteArticle;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Livewire\Livewire;

it('should show the modal', function (): void {
    $user    = User::factory()->create();
    $article = Article::factory()->create();

    $component = Livewire::actingAs($user)->test(DeleteArticle::class);
    $component->call('open', $article->id);
    $component->assertSet('modalShown', true);
    $component->assertSet('article', fn ($property) => $property->is($article));
});

it('should hide the modal', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test(DeleteArticle::class);
    $component->call('close');
    $component->assertSet('modalShown', false);
    $component->assertSet('article', null);
});

it('should be able to delete an article', function (): void {
    $user = User::factory()->create();

    $article = Article::factory()->create(['title' => 'Hello World']);

    $component = Livewire::actingAs($user)
        ->test(DeleteArticle::class)
        ->call('open', $article->id)
        ->assertHasNoErrors();

    expect(Article::count())->toBe(1);

    $component
        ->call('deleteUser')
        ->assertSet('modalShown', false)
        ->assertSet('article', null)
        ->assertRedirect(route('kiosk.articles'));

    expect(Article::count())->toBe(0);
});
