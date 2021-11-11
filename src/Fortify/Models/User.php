<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Models;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends UserWithoutVerification implements MustVerifyEmail
{
    public function canModerate(): bool
    {
        return $this->hasRole([
            app(UserRole::class)::SUPER_ADMIN,
            app(UserRole::class)::ADMIN,
        ]);
    }
}
