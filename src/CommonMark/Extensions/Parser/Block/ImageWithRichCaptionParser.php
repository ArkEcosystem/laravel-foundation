<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Parser\Block;

use ARKEcosystem\Foundation\CommonMark\Extensions\Node\Block\ImageWithRichCaption;
use Illuminate\Support\Arr;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Block\BlockContinueParserWithInlinesInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\InlineParserEngineInterface;

final class ImageWithRichCaptionParser extends AbstractBlockContinueParser implements BlockContinueParserWithInlinesInterface
{
    /** @psalm-readonly */
    private ImageWithRichCaption $block;

    private string $content = '';

    private bool $finished = false;

    public function __construct()
    {
        $this->block = new ImageWithRichCaption();
    }

    public function getBlock(): ImageWithRichCaption
    {
        return $this->block;
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        if ($this->finished) {
            return BlockContinue::finished();
        }

        return BlockContinue::at($cursor);
    }

    public function addLine(string $line): void
    {
        if ($this->content !== '') {
            $this->content .= "\n";
        }

        $this->content .= $line;

        if (\preg_match('/\[\/img\]/', $line) === 1) {
            $this->finished = true;
        }
    }

    public function parseInlines(InlineParserEngineInterface $inlineParser): void
    {
        $data = $this->getSrcAndContent();

        $content = sprintf('![](%s)<span class="rich-image-caption image-caption">%s</span>', $data['src'], $data['content']);

        $inlineParser->parse($content."\n\n", $this->block);
    }

    private function getSrcAndContent(): array
    {
        $regex = '/\[img.*src=["“\'](?<src>[^"”\']*)["”\'][^]]*](?<content>[\S\s]*)(?=\[\/img])/m';

        preg_match($regex, $this->content, $matches);

        return [
            'src'     => Arr::get($matches, 'src'),
            'content' => Arr::get($matches, 'content'),
        ];
    }
}
