<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support\Enums;

/* @TODO: make this class "enum" */
final class AlertType
{
    public const INFO = 'info';

    public const SUCCESS = 'success';

    public const WARNING = 'warning';

    public const ERROR = 'error';

    public const QUESTION = 'question';
}
