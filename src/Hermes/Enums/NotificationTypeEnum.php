<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Hermes\Enums;

enum NotificationTypeEnum: string
{
    case SUCCESS = 'success';

    case WARNING = 'warning';

    case DANGER = 'danger';

    case BLOCKED = 'blocked';

    case COMMENT = 'comment';

    case MENTION = 'mention';

    case ANNOUNCEMENT = 'announcement';

    case VIDEO = 'video';

    public static function isDanger(string $type): bool
    {
        return self::tryFrom($type) === self::DANGER;
    }

    public static function isSuccess(string $type): bool
    {
        return self::tryFrom($type) === self::SUCCESS;
    }

    public static function isWarning(string $type): bool
    {
        return self::tryFrom($type) === self::WARNING;
    }

    public static function isBlocked(string $type): bool
    {
        return self::tryFrom($type) === self::BLOCKED;
    }

    public static function isComment(string $type): bool
    {
        return self::tryFrom($type) === self::COMMENT;
    }

    public static function isMention(string $type): bool
    {
        return self::tryFrom($type) === self::MENTION;
    }

    public static function isAnnouncement(string $type): bool
    {
        return self::tryFrom($type) === self::ANNOUNCEMENT;
    }

    public static function isVideo(string $type): bool
    {
        return self::tryFrom($type) === self::VIDEO;
    }
}
