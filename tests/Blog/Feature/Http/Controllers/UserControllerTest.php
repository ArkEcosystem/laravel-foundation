<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\User;

it('can render user kiosk', function () {
    $user = User::factory()->create();

    $this->actingAs(User::factory()->create(['two_factor_secret' => 'code']))
        ->get(route('kiosk.users'))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.kiosk.users')
        ->assertViewHas('users', fn ($users) => $users->getCollection()->count() === 2);
});

it('can render a user update page', function () {
    $user = User::factory()->create();

    $this->actingAs(User::factory()->create(['two_factor_secret' => 'code']))
        ->get(route('kiosk.user', $user))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.kiosk.user')
        ->assertViewHas('user', fn ($u) => $u->is($user));
});

it('can render a page for creating a new ser', function () {
    $this->actingAs(User::factory()->create(['two_factor_secret' => 'code']))
        ->get(route('kiosk.users.create'))
        ->assertOk()
        ->assertViewIs('ark::pages.blog.kiosk.users.create');
});
