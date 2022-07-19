<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Node\Block;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Node\RawMarkupContainerInterface;

class ImageWithRichCaption extends AbstractBlock implements RawMarkupContainerInterface
{
    private string $literal = '';

    public function getLiteral(): string
    {
        return $this->literal;
    }

    public function setLiteral(string $literal): void
    {
        $this->literal = $literal;
    }
}
