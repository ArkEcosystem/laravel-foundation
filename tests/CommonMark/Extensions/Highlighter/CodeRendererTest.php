<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\CodeRenderer;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Renderer\HtmlRenderer;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

beforeEach(function () {
    $this->inlineCode = new Code();
    $this->renderer   = new CodeRenderer();

    $document = new Document();

    $documentRenderer = $this->createMock(NodeRendererInterface::class);
    $documentRenderer->method('render')->willReturn('::document::');

    $environment = new Environment();
    $environment->addRenderer(Document::class, $documentRenderer);
    $this->htmlRenderer = new HtmlRenderer($environment);
});

it('should render', function () {
    $this->inlineCode->setLiteral('<span>test</span>');

    $result = $this->renderer->render($this->inlineCode, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('code');
    expect($result->getContents())->toBe('&lt;span&gt;test&lt;/span&gt;');
});

it('should parse encoded html characters', function () {
    $this->inlineCode->setLiteral('&lt;span&gt;test&lt;/span&gt;');

    $result = $this->renderer->render($this->inlineCode, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('code');
    expect($result->getContents())->toBe('&lt;span&gt;test&lt;/span&gt;');
});

it('should do nothing if no encoded html characters', function () {
    $this->inlineCode->setLiteral('this is a test');

    $result = $this->renderer->render($this->inlineCode, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('code');
    expect($result->getContents())->toBe('this is a test');
});

it('should get an xml tag name', function () {
    expect($this->renderer->getXmlTagName($this->inlineCode))->toBe('code');
});

it('should return no xml attributes', function () {
    expect($this->renderer->getXmlAttributes($this->inlineCode))->toBe([]);
});
