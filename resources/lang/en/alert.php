<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Support\Enums\AlertType;

return [

    AlertType::INFO => 'Information',
    AlertType::SUCCESS => 'Success',
    AlertType::WARNING => 'Alert/Warning',
    AlertType::ERROR => 'Error',
    AlertType::QUESTION => 'Help',
];
