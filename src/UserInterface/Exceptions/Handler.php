<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * Register the error template hint paths.
     *
     * @return void
     */
    protected function registerErrorViewPaths()
    {
        View::replaceNamespace('errors', __DIR__.'/../../../resources/views/errors');
    }

    /**
     * Get the view used to render HTTP exceptions.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return string|null
     */
    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
        $view = parent::getHttpExceptionView($e);
        if ($view) {
            return $view;
        }

        return 'errors::500';
    }
}
