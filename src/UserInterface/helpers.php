<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\SvgLazy;
use ARKEcosystem\Foundation\UserInterface\Support\Enums\FlashType;

if (! function_exists('svgLazy')) {
    function svgLazy(string $name, $class = ''): SvgLazy
    {
        return new SvgLazy($name, $class);
    }
}

if (! function_exists('formatReadTime')) {
    function formatReadTime(int $minutes): string
    {
        $readTime = (new DateTime())->setTime(0, $minutes);

        return sprintf(
            '%s %s',
            trans_choice('generic.time.hour', (int) $readTime->format('H'), ['value' => (int) $readTime->format('H')]),
            trans_choice('generic.time.min', (int) $readTime->format('i'), ['value' => (int) $readTime->format('i')])
        );
    }
}

if (! function_exists('alertIcon')) {
    function alertIcon(string $type): string
    {
        if (in_array($type, ['success', 'error', 'danger', 'hint', 'warning', 'info'], true)) {
            return [
                'success' => 'circle.check-mark-big',
                'error'   => 'circle.cross-big',
                'danger'  => 'circle.cross-big',
                'hint'    => 'circle.question-mark-big',
                'warning' => 'circle.exclamation-mark',
                'info'    => 'circle.info',
            ][$type];
        }

        return 'circle.info';
    }
}

if (! function_exists('clearZalgoText')) {
    function clearZalgoText(string $zalgo): string
    {
        return preg_replace("|[\p{M}]|uis", '', $zalgo);
    }
}

if (! function_exists('call_user_func_safe')) {
    function call_user_func_safe(array $callback, mixed ...$args): mixed
    {
        if (is_callable($callback)) {
            return call_user_func($callback, ...$args);
        }

        throw new RuntimeException("Method [$callback[1]] is not callable.");
    }
}

if (! function_exists('alert')) {
    /** @param FlashType::* $type */
    function alert(string $key, $type, array $translationVariables = []): void
    {
        flash(trans($key, $translationVariables), $type);
    }
}
