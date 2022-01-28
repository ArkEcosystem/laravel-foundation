<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support\Enums;

enum AlertType: string
{
    case INFO = 'info';

    case SUCCESS = 'success';

    case WARNING = 'warning';

    case ERROR = 'error';

    case HINT = 'hint';
}
