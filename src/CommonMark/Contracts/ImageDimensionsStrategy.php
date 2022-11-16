<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Contracts;

interface ImageDimensionsStrategy
{
    /**
     * @param string $url
     * @return array<string, string>|null
     */
    public static function getDimensionsFromUrl(string $url): ?array;
}
