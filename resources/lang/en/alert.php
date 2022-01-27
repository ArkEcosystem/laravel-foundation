<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Support\Enums\AlertType;

return [
    AlertType::INFO->value    => 'Information',
    AlertType::SUCCESS->value => 'Success',
    AlertType::WARNING->value => 'Warning',
    AlertType::ERROR->value   => 'Error',
    AlertType::HINT->value    => 'Help',
    'dismiss'                 => 'Dismiss alert',
];
