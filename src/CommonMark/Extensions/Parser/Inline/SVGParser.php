<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Parser\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

final class SVGParser implements InlineParserInterface
{
    private const SVG_REGEX = '<(?:svg|SVG)[^>]*>';

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex(self::SVG_REGEX);
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $inlineContext->getCursor()->advanceBy($inlineContext->getFullMatchLength());

        $match = $inlineContext->getFullMatch();

        $inlineContext->getContainer()->appendChild(new HtmlInline($match));

        return true;
    }
}
