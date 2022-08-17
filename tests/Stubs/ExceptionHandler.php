<?php

declare(strict_types=1);

namespace Tests\Stubs;

use ARKEcosystem\Foundation\UserInterface\Exceptions\Concerns\OverridesExceptionView;
use Orchestra\Testbench\Exceptions\Handler as Base;

class ExceptionHandler extends Base
{
    use OverridesExceptionView;
}
