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
            trans_choice('generic.time.hour', (int) $readTime->format('H'), ['value' => (int) $readTime->format('H')]),
            trans_choice('generic.time.min', (int) $readTime->format('i'), ['value' => (int) $readTime->format('i')])
        );
    }
}

if (! function_exists('alertIcon')) {
    function alertIcon(AlertType $type): string
    {
        return match ($type->value) {
            AlertType::INFO->value    => 'circle.info',
            AlertType::SUCCESS->value => 'circle.check-mark',
            AlertType::WARNING->value => 'circle.exclamation-mark',
            AlertType::ERROR->value   => 'circle.cross',
            AlertType::HINT->value    => 'circle.question-mark',
        };
    }
}

if (! function_exists('alertTitle')) {
    function alertTitle(AlertType $type): string
    {
        return match ($type->value) {
            AlertType::INFO->value    => trans('ui::alert.'.AlertType::INFO->value),
            AlertType::SUCCESS->value => trans('ui::alert.'.AlertType::SUCCESS->value),
            AlertType::WARNING->value => trans('ui::alert.'.AlertType::WARNING->value),
            AlertType::ERROR->value   => trans('ui::alert.'.AlertType::ERROR->value),
            AlertType::HINT->value    => trans('ui::alert.'.AlertType::HINT->value),
        };
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
