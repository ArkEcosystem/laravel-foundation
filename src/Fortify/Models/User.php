<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Models;

use ARKEcosystem\Foundation\Fortify\Support\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends UserWithoutVerification implements MustVerifyEmail
{
    public function canModerate(): bool
    {
        return $this->hasRole([
            UserRole::SUPER_ADMIN,
            UserRole::ADMIN,
        ]);
    }
}
