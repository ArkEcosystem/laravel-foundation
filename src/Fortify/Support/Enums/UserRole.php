<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Support\Enums;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole as UserRoleContract;

enum UserRole: string implements UserRoleContract
{
    case SUPER_ADMIN = 'super-admin';

    case ADMIN = 'admin';

    public static function toArray(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::ADMIN->value,
        ];
    }
}
