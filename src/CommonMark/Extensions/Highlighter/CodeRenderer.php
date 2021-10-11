<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter;

use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\Concerns\DecodesHtmlEntities;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\Xml;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class CodeRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    use DecodesHtmlEntities;

    /**
     * @param Code $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Code::assertInstanceOf($node);
        $node = $this->parseEncodedHtml($node);

        $attrs = $node->data->get('attributes');

        return new HtmlElement('code', $attrs, Xml::escape($node->getLiteral()));
    }

    public function getXmlTagName(Node $node): string
    {
        return 'code';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
