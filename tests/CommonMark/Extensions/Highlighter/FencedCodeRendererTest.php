<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\FencedCodeRenderer;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Renderer\HtmlRenderer;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

beforeEach(function () {
    $this->block = new FencedCode(3, '`', 0);
    $this->renderer = new FencedCodeRenderer();

    $document = new Document();

    $documentRenderer = $this->createMock(NodeRendererInterface::class);
    $documentRenderer->method('render')->willReturn('::document::');

    $environment = new Environment();
    $environment->addRenderer(Document::class, $documentRenderer);
    $this->htmlRenderer = new HtmlRenderer($environment);
});

it('should render', function () {
    $this->block->setInfo('blade');
    $this->block->setLiteral('<span>test</span>');

    $result = $this->renderer->render($this->block, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('div');
    expect($result->getContents(false)->getTagName())->toBe('pre');
    expect($result->getContents())->toContain('<code class="hljs-copy language-blade">');
    expect($result->getContents())->toContain('&lt;span&gt;test&lt;/span&gt;');
    expect($result->getAllAttributes())->toBe([
        'class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto',
    ]);
    expect($result->getContents(false)->getAllAttributes())->toBe(['class' => 'hljs']);
});

it('should parse encoded html characters', function ($type) {
    $this->block->setInfo($type);
    $this->block->setLiteral('&lt;span&gt;test&lt;/span&gt;');

    $result = $this->renderer->render($this->block, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('div');
    expect($result->getContents(false)->getTagName())->toBe('pre');
    expect($result->getContents())->toContain('<code class="hljs-copy language-'.$type.'">');
    expect($result->getContents())->toContain('&lt;span&gt;test&lt;/span&gt;');
    expect($result->getAllAttributes())->toBe([
        'class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto',
    ]);
    expect($result->getContents(false)->getAllAttributes())->toBe(['class' => 'hljs']);
})->with([
    'blade',
    'html',
]);

it('should do nothing if no encoded html characters', function ($type) {
    $this->block->setInfo($type);
    $this->block->setLiteral('this is a test');

    $result = $this->renderer->render($this->block, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('div');
    expect($result->getContents(false)->getTagName())->toBe('pre');
    expect($result->getContents())->toContain('<code class="hljs-copy language-'.$type.'">');
    expect($result->getContents())->toContain('this is a test');
    expect($result->getAllAttributes())->toBe([
        'class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto',
    ]);
    expect($result->getContents(false)->getAllAttributes())->toBe(['class' => 'hljs']);
})->with([
    'blade',
    'html',
]);

it('should not parse encoded characters if not html type', function () {
    $this->block->setInfo('php');
    $this->block->setLiteral('echo "&lt;span&gt;test&lt;/span&gt;";');

    $result = $this->renderer->render($this->block, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('div');
    expect($result->getContents(false)->getTagName())->toBe('pre');
    expect($result->getContents())->toContain('<code class="hljs-copy language-php">');
    expect($result->getContents())->toContain('echo &quot;&amp;lt;span&amp;gt;test&amp;lt;/span&amp;gt;&quot;;');
    expect($result->getAllAttributes())->toBe([
        'class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto',
    ]);
    expect($result->getContents(false)->getAllAttributes())->toBe(['class' => 'hljs']);
});

it('should handle line numbers', function () {
    $this->block->setInfo('plaintext');
    $this->block->setLiteral('test
        test
        test');

    $result = $this->renderer->render($this->block, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('div');
    expect($result->getContents(false)->getTagName())->toBe('pre');
    expect($result->getContents())->toContain('<code class="hljs-copy language-plaintext">');
    expect($result->getContents())->toContain('test
        test
        test');
    expect($result->getAllAttributes())->toBe([
        'class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto',
    ]);
    expect($result->getContents(false)->getAllAttributes())->toBe(['class' => 'hljs line-numbers']);
});

it('should handle no codeblock type', function () {
    $this->block->setInfo('');
    $this->block->setLiteral('test
        test
        test');

    $result = $this->renderer->render($this->block, $this->htmlRenderer);

    expect($result)->toBeInstanceOf(HtmlElement::class);
    expect($result->getTagName())->toBe('div');
    expect($result->getContents(false)->getTagName())->toBe('pre');
    expect($result->getContents())->toContain('<code class="hljs-copy language-plaintext">');
    expect($result->getContents())->toContain('test
        test
        test');
    expect($result->getAllAttributes())->toBe([
        'class' => 'p-4 mb-6 rounded-xl bg-theme-secondary-800 overflow-x-auto',
    ]);
    expect($result->getContents(false)->getAllAttributes())->toBe(['class' => 'hljs line-numbers']);
});

it('should get an xml tag name', function () {
    expect($this->renderer->getXmlTagName($this->block))->toBe('code_block');
});

it('should get xml attributes', function () {
    $this->block->setInfo('blade');

    expect($this->renderer->getXmlAttributes($this->block))->toBe(['info' => 'blade']);
});

it('should get no xml attributes if no codeblock type', function () {
    expect($this->renderer->getXmlAttributes($this->block))->toBe([]);
});
