<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\CommonMark\Extensions\ExternalLink\ExternalLinkExtension;
use ARKEcosystem\Foundation\CommonMark\Extensions\Link\LinkRenderer;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Renderer\HtmlRenderer;
use League\CommonMark\Renderer\Inline\TextRenderer;
use League\Config\Configuration;
use League\CommonMark\MarkdownConverterInterface;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should render internal links', function (string $url) {
    $environment = app(MarkdownConverterInterface::class)->getEnvironment();
    $environment->addExtension(resolve(ExternalLinkExtension::class));

    $subject = new LinkRenderer($environment);
    $subject->setConfiguration($environment->getConfiguration());

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
    $environment = app(MarkdownConverterInterface::class)->getEnvironment();
    $environment->addExtension(resolve(ExternalLinkExtension::class));

    $subject = new LinkRenderer($environment);
    $subject->setConfiguration($environment->getConfiguration());

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
    $environment = app(MarkdownConverterInterface::class)->getEnvironment();
    $environment->addExtension(resolve(ExternalLinkExtension::class));

    $subject = new LinkRenderer($environment);
    $subject->setConfiguration($environment->getConfiguration());

    $element = $subject->render(new Link($host, 'Label', 'Title'), new HtmlRenderer($environment));

    $this->expect($element->getAttribute('href'))->toBe('https://'.$host);
})->with([
    'google.com',
    'www.google.com',
    'google.com/something',
]);

it('should render relative paths', function (string $path) {
    $environment = app(MarkdownConverterInterface::class)->getEnvironment();
    $environment->addExtension(resolve(ExternalLinkExtension::class));

    $subject = new LinkRenderer($environment);
    $subject->setConfiguration($environment->getConfiguration());

    $element = $subject->render(new Link($path, 'Label', 'Title'), new HtmlRenderer($environment));

    $this->expect($element->getAttribute('href'))->toBe($path);
})->with([
    '/local/path',
    'path',
    'path/version/1.2/thing',
    'docs/core/releases/upgrade/docker/3.0',
]);

it('should apply infix for external links', function (string $path, bool $isExternal) {
    $environment = app(MarkdownConverterInterface::class)->getEnvironment();
    $environment->addExtension(resolve(ExternalLinkExtension::class));

    $subject = new LinkRenderer($environment);
    $subject->setConfiguration($environment->getConfiguration());

    $element = $subject->render(new Link($path, 'Label', 'Title'), new HtmlRenderer($environment));

    if ($isExternal) {
        $this->expect($element->getAttribute('data-external'))->toBe('true');
        $this->expect($element->getContents())->toStartWith('Label @');
    } else {
        $this->expect($element->getAttribute('data-external'))->toBeNull();
        $this->expect($element->getContents())->toBe('Label');
    }
})->with([
    ['/local/path', false],
    ['path', true],
    ['path/version/1.2/thing', true],
    ['docs/core/releases/upgrade/docker/3.0', true],
]);
