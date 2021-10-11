<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Renderer\Block\FencedCodeRenderer as BaseFencedCodeRenderer;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\Html5EntityDecoder;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\Xml;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class FencedCodeRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    /** @var \ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\CodeBlockHighlighter */
    private $highlighter;

    /** @var \League\CommonMark\Extension\CommonMark\Renderer\Block\FencedCodeRenderer */
    private $baseRenderer;

    public function __construct()
    {
        $this->highlighter  = new CodeBlockHighlighter();
        $this->baseRenderer = new BaseFencedCodeRenderer();
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        $language = $this->getSpecifiedLanguage($node);
        if ($language && in_array(strtolower($language), ['blade', 'html'])) {
            $node = $this->parseEncodedHtml($node);
        }

        $element = $this->baseRenderer->render($node, $childRenderer);

        $this->configureLineNumbers($element);

        $element->setContents(
            $this->highlighter->highlight($element->getContents(), $language)
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

    private function getSpecifiedLanguage(FencedCode $block): ?string
    {
        $infoWords = $block->getInfoWords();

        /* @phpstan-ignore-next-line */
        if (empty($infoWords) || empty($infoWords[0])) {
            return 'plaintext';
        }

        return Xml::escape($infoWords[0]);
    }

    private function parseEncodedHtml(Node $node): Node
    {
        $content        = $node->getLiteral();
        $hasEncodedHtml = preg_match_all('/&(\w+|\d+);/', $content, $matches);
        if ($hasEncodedHtml === false || $hasEncodedHtml === 0) {
            return $node;
        }

        $entitiesToUpdate = [];
        foreach (array_unique($matches[0]) as $element) {
            $entitiesToUpdate[$element] = Html5EntityDecoder::decode($element);
        }

        $content = str_replace(array_keys($entitiesToUpdate), $entitiesToUpdate, $content);

        $node->setLiteral($content);

        return $node;
    }
}
