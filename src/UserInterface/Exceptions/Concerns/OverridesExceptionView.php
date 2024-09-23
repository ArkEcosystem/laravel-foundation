<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Exceptions\Concerns;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

trait OverridesExceptionView
{
    /**
     * Get the view used to render HTTP exceptions.
     *
     * @param  HttpExceptionInterface  $e
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
