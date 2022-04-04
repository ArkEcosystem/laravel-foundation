<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

class DocumentView
{
    public static function get(string $type, string $category, string $page): string
    {
        return 'docs::'.$type.'.'.$category.'.'.$page;
    }

    public static function getIndex(string $type, string $category): string
    {
        return static::get($type, $category, 'index');
    }
}
