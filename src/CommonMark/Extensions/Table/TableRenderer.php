<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Table;

use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class TableRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Table::assertInstanceOf($node);

        $attrs = $node->data->get('attributes', []);

        $separator = $childRenderer->getInnerSeparator();

        $children = $childRenderer->renderNodes($node->children());

        $table = new HtmlElement('table', $attrs, $separator.\trim($children).$separator);

        try {
            $table->setContents($table->getContents());
        } catch (\Throwable) {
            $table->setContents($table->getContents());
        }

        $container = new HtmlElement('div', ['class' => 'table-wrapper overflow-x-auto']);
        $container->setContents($table);

        return $container;
    }

    public function getXmlTagName(Node $node): string
    {
        return 'table';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
