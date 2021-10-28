<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Actions\DeleteUser;
use ARKEcosystem\Foundation\Fortify\Models\User;

it('should delete a user', function () {
    Config::set('fortify.models.user', \ARKEcosystem\Foundation\Fortify\Models\User::class);

    $user = User::create([
        'name'     => 'John Doe',
        'username' => 'johndoe',
        'email'    => 'john@doe.com',
        'password' => 'password',
    ]);

    expect(User::find($user->id)->id)->toBe($user->id);

    (new DeleteUser())->delete($user);

    expect(User::find($user->id))->toBeNull();
});
