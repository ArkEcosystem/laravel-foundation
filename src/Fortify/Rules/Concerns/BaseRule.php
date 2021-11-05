<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Rules\Concerns;

abstract class BaseRule
{
    abstract public static function passes(string $attribute, mixed $value): bool;

    abstract public static function message(array $attributes = []): string;
}
