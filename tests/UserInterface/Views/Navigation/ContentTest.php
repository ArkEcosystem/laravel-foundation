<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\User;

it('should render the [profile] slot', function (): void {
    $this
        ->actingAs(new User())
        ->view('ark::navbar.content', [
            'profile' => 'profile slot',
        ])
        ->assertSeeText('profile slot');
});
