<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;

class Handler extends ExceptionHandler
{
    use Concerns\OverridesExceptionView;

    /**
     * Register the error template hint paths.
     *
     * @return void
     */
    protected function registerErrorViewPaths()
    {
        View::replaceNamespace('errors', __DIR__.'/../../../resources/views/errors');
    }
}
