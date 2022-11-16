<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Contracts;

interface ImageDimensionsStrategy
{
    /**
     * @param string $url
     * @return array<int, int>|null
     */
    public function getDimensions(string $url): array;
}
