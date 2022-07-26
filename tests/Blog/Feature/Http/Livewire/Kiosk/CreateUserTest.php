<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Components\Kiosk\CreateUser;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('creates the user', function () {
    Storage::fake('public');

    $photo = File::image('dummy-image.jpg');

    Livewire::actingAs($user = User::factory()->create())
            ->test(CreateUser::class)
            ->set('state', [
                'name'     => 'John Doe',
                'email'    => 'john@example.com',
                'password' => 'secret',
            ])
            ->set('state.photo', $photo)
            ->call('save');

    $user = User::latest('id')->first();

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@example.com');
    expect(Hash::check('secret', $user->password))->toBeTrue();
    expect($user->photo())->not->toBe('/images/user/placeholder-photo.png');
});
