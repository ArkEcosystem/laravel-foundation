<?php

namespace Tests\Stubs;

use ARKEcosystem\Foundation\UserInterface\Exceptions\Concerns\OverridesExceptionView;
use Orchestra\Testbench\Exceptions\Handler as Base;
use Throwable;

class ExceptionHandler extends Base
{
    use OverridesExceptionView;
}
