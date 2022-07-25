<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;

it('has a profile photo', function () {
    $user = User::factory()->create();

    expect($user->photo())->toBe('/images/user/placeholder-photo.png');

    Storage::fake('public');

    $user->addMedia(
        File::image('dummy-photo.jpg')
    )->toMediaCollection('photo');

    expect($user->fresh()->photo())->toMatch('/^\/storage\/[0-9]+\/dummy-photo\.jpg$/');
});
