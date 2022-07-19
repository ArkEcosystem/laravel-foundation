<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Parser\Block;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;
use League\CommonMark\Util\RegexHelper;

final class ImageWithRichCaptionStartParser implements BlockStartParserInterface
{
    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented() || $cursor->getNextNonSpaceCharacter() !== '[') {
            return BlockStart::none();
        }

        $tmpCursor = clone $cursor;
        $tmpCursor->advanceToNextNonSpaceOrTab();
        $line = $tmpCursor->getRemainder();

        $match = RegexHelper::matchAt(
            '/\[img.*src=["“\'](?<src>[^"”\']*)["”\'][^]]*]/',
            $line
        );

        if ($match !== null) {
            return BlockStart::of(new ImageWithRichCaptionParser())->at($cursor);
        }

        return BlockStart::none();
    }
}
