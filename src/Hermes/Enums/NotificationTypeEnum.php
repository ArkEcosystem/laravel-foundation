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
}
