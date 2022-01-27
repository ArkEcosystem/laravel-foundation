<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Hermes\Enums;

enum NotificationFilterEnum: string
{
    case ALL = 'all';

    case READ = 'read';

    case UNREAD = 'unread';

    case STARRED = 'starred';

    case UNSTARRED = 'unstarred';

    public static function isAll(string $value):bool
    {
        return self::tryFrom($value) === self::ALL;
    }
}
