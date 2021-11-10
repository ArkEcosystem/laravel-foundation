<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Support\Enums;

final class UserRole
{
    public const SUPER_ADMIN = 'super-admin';

    public const ADMIN = 'admin';

    public static function toArray(): array
    {
        return [
            static::SUPER_ADMIN,
            static::ADMIN,
        ];
    }
}
