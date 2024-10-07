<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter;

use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\Xml;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class IndentedCodeRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    /** @var CodeBlockHighlighter */
    private $highlighter;

    public function __construct()
    {
        $this->highlighter  = new CodeBlockHighlighter();
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        IndentedCode::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');

        $element = new HtmlElement('code', $attrs, Xml::escape($node->getLiteral()));

        return new HtmlElement(
            'pre',
            [],
            $this->highlighter->highlight($element->getContents()),
        );
    }

    public function getXmlTagName(Node $node): string
    {
        return 'code_block';
    }

    /**
     * @return array<string, scalar>
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
