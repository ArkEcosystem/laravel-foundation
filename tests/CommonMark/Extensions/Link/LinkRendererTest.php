<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\CommonMark\Extensions\Link\LinkRenderer;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Renderer\HtmlRenderer;
use League\CommonMark\Renderer\Inline\TextRenderer;
use League\Config\Configuration;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should render internal links', function (string $url) {
    $subject = new LinkRenderer();
    $subject->setConfiguration(new Configuration());

    $environment = new Environment();
    $environment->addRenderer(Text::class, new TextRenderer());

    $element = $subject->render(new Link($url, 'Label', 'Title'), new HtmlRenderer($environment));

    $this->expect($element->getAttribute('target'))->not->toBe('_blank');
    assertMatchesSnapshot((string) $element);
})->with([
    'https://ourapp.com',
    '#heading',
    '/path/segment',
    'mailto:test@ark.io',
]);

it('should render external links', function (string $url) {
    $subject = new LinkRenderer();
    $subject->setConfiguration(new Configuration());

    $environment = new Environment();
    $environment->addRenderer(Text::class, new TextRenderer());

    $element = $subject->render(new Link($url, 'Label', 'Title'), new HtmlRenderer($environment));

    $this->expect($element->getAttribute('target'))->toBe('_blank');
    assertMatchesSnapshot((string) $element);
})->with([
    'https://google.com',
    'unsupported/relative/url', // is valid, but currently not supported
    'ftp://google.com',
    '//google.com',
]);

it('should render links without schema as links', function (string $host) {
    $subject = new LinkRenderer();
    $subject->setConfiguration(new Configuration());

    $environment = new Environment();
    $environment->addRenderer(Text::class, new TextRenderer());

    $element = $subject->render(new Link($host, 'Label', 'Title'), new HtmlRenderer($environment));

    $this->expect($element->getAttribute('href'))->toBe('http://' . $host);
})->with([
    'google.com',
    'www.google.com',
    'google.com/something',
]);

it('should render relative paths', function (string $path) {
    $subject = new LinkRenderer();
    $subject->setConfiguration(new Configuration());

    $environment = new Environment();
    $environment->addRenderer(Text::class, new TextRenderer());

    $element = $subject->render(new Link($path, 'Label', 'Title'), new HtmlRenderer($environment));

    $this->expect($element->getAttribute('href'))->toBe($path);
})->with([
    '/local/path',
    'path',
    'path/version/1.2/thing',
    'docs/core/releases/upgrade/docker/3.0',
]);
