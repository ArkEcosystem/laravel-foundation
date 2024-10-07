<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter;

use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\Concerns\DecodesHtmlEntities;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Renderer\Block\FencedCodeRenderer as BaseFencedCodeRenderer;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\Xml;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class FencedCodeRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    use DecodesHtmlEntities;

    /** @var CodeBlockHighlighter */
    private $highlighter;

    /** @var BaseFencedCodeRenderer */
    private $baseRenderer;

    public function __construct()
    {
        $this->highlighter  = new CodeBlockHighlighter();
        $this->baseRenderer = new BaseFencedCodeRenderer();
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        $element = $this->baseRenderer->render(
            $this->parseEncodedHtml($node),
            $childRenderer
        );

        $this->configureLineNumbers($element);

        $element->setContents(
            $this->highlighter->highlight(
                $element->getContents(),
                $this->getSpecifiedLanguage($node)
            )
        );

        $container = new HtmlElement('div', ['class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto']);
        $container->setContents($element);

        return $container;
    }

    public function getXmlTagName(Node $node): string
    {
        return 'code_block';
    }

    /**
     * @param FencedCode $node
     *
     * @return array<string, scalar>
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function getXmlAttributes(Node $node): array
    {
        FencedCode::assertInstanceOf($node);

        if (($info = $node->getInfo()) === null || $info === '') {
            return [];
        }

        return ['info' => $info];
    }

    private function configureLineNumbers(HtmlElement $element): void
    {
        $codeBlockWithoutTags = strip_tags($element->getContents());
        $contents             = trim(htmlspecialchars_decode($codeBlockWithoutTags));

        if (count(explode("\n", $contents)) === 1) {
            $element->setAttribute('class', 'hljs');
        } else {
            $element->setAttribute('class', 'hljs line-numbers');
        }
    }

    private function getSpecifiedLanguage(FencedCode $block): string
    {
        $infoWords = $block->getInfoWords();

        /* @phpstan-ignore-next-line */
        if (empty($infoWords) || empty($infoWords[0])) {
            return 'plaintext';
        }

        return Xml::escape($infoWords[0]);
    }
}
