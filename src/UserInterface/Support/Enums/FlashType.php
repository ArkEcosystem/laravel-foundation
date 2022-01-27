<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support\Enums;

enum FlashType: string
{
    case INFO    = 'info';

    case SUCCESS = 'success';

    case WARNING = 'warning';

    case DANGER  = 'danger';

    case ERROR   = 'error';

    case HINT    = 'hint';
}
