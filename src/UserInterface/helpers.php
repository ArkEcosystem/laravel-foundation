<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\SvgLazy;
use ARKEcosystem\Foundation\UserInterface\Support\Enums\AlertType;

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
            trans_choice('ui::generic.time.hour', (int) $readTime->format('H'), ['value' => (int) $readTime->format('H')]),
            trans_choice('ui::generic.time.min', (int) $readTime->format('i'), ['value' => (int) $readTime->format('i')])
        );
    }
}

if (! function_exists('alertIcon')) {
    function alertIcon(string $type): string
    {
        if (in_array($type, [
            AlertType::INFO,
            AlertType::SUCCESS,
            AlertType::WARNING,
            AlertType::ERROR,
            AlertType::HINT,
        ], true)) {
            return [
                AlertType::INFO     => 'circle.info',
                AlertType::SUCCESS  => 'circle.check-mark',
                AlertType::WARNING  => 'circle.exclamation-mark',
                AlertType::ERROR    => 'circle.cross',
                AlertType::HINT     => 'circle.question-mark',
            ][$type];
        }

        return 'circle.info';
    }
}

if (! function_exists('alertTitle')) {
    function alertTitle(string $type): string
    {
        if (in_array($type, [
            AlertType::INFO,
            AlertType::SUCCESS,
            AlertType::WARNING,
            AlertType::ERROR,
            AlertType::HINT,
        ], true)) {
            return [
                AlertType::INFO     => trans('ui::alert.'.AlertType::INFO),
                AlertType::SUCCESS  => trans('ui::alert.'.AlertType::SUCCESS),
                AlertType::WARNING  => trans('ui::alert.'.AlertType::WARNING),
                AlertType::ERROR    => trans('ui::alert.'.AlertType::ERROR),
                AlertType::HINT     => trans('ui::alert.'.AlertType::HINT),
            ][$type];
        }

        return trans('ui::alert.'.AlertType::INFO);
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
    /* @TODO: change `string $type` to `AlertType $type` */
    function alert(string $key, string $type, array $translationVariables = []): void
    {
        flash(trans($key, $translationVariables), $type);
    }
}
