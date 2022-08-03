<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Renderer\Block;

use ARKEcosystem\Foundation\CommonMark\Extensions\Node\Block\ImageWithRichCaption;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class ImageWithRichCaptionRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    /**
     * @param ImageWithRichCaption $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        ImageWithRichCaption::assertInstanceOf($node);

        $innerSeparator = $childRenderer->getBlockSeparator();

        return new HtmlElement(
            'p',
            [],
            new HtmlElement(
                'div',
                [
                    'class' => 'image-container',
                ],
                $innerSeparator.$childRenderer->renderNodes($node->children()).$innerSeparator
            )
        );
    }

    public function getXmlTagName(Node $node): string
    {
        return 'image_with_richcaption';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
