<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Components\Kiosk\UpdateUser;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('updates the article', function () {
    $user = User::factory()->create([
        'name'     => 'John Doe',
        'email'    => 'john@example.com',
        'password' => Hash::make('secret'),
    ]);

    Storage::fake('public');

    $photo = File::image('dummy-photo.jpg');

    expect($user->photo())->toBe('/images/user/placeholder-photo.png');

    Livewire::actingAs(User::factory()->create())
            ->test(UpdateUser::class, ['user' => $user])
            ->assertSet('state.name', 'John Doe')
            ->set('state.photo', $photo)
            ->set('state.name', 'Jane Doe')
            ->call('save');

    $user->refresh();

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('john@example.com');
    expect(Hash::check('secret', $user->password))->toBeTrue();
    expect($user->photo())->not->toBe('/images/user/placeholder-photo.png');
});
