<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

final class ImageRenderer implements NodeRendererInterface, XmlNodeRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected ConfigurationInterface $config;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable|string|null
    {
        Image::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');

        $forbidUnsafeLinks = $this->config->get('allow_unsafe_links', true) !== true;
        if ($forbidUnsafeLinks && RegexHelper::isLinkPotentiallyUnsafe($node->getUrl())) {
            $attrs['src'] = '';
        } else {
            $attrs['src'] = $node->getUrl();
        }

        $alt          = $childRenderer->renderNodes($node->children());
        $alt          = \preg_replace('/\<[^>]*alt="([^"]*)"[^>]*\>/', '$1', $alt);
        $attrs['alt'] = \preg_replace('/\<[^>]*\>/', '', $alt);

        /* @phpstan-ignore-next-line */
        if (($title = $node->getTitle()) !== null) {
            $attrs['title'] = $title;
        }

        $url = MediaUrlParser::parse($node->getUrl());

        if ($url !== null) {
            if ($url->isSimpleCast()) {
                $content = SimpleCastRenderer::render($url);
            } elseif ($url->isTwitter()) {
                $content = TwitterRenderer::render($url);
            } elseif ($url->isYouTube()) {
                $content = YouTubeRenderer::render($url);
            } else {
                $content = new HtmlElement('img', $attrs, '', true);
            }
        } else {
            $content = new HtmlElement('img', $attrs, '', true);
        }

        return ContainerRenderer::render($content, $attrs['alt']);
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    public function getXmlTagName(Node $node): string
    {
        return 'image';
    }

    /**
     * @param Image $node
     *
     * @return array<string, scalar>
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function getXmlAttributes(Node $node): array
    {
        Image::assertInstanceOf($node);

        return [
            'destination' => $node->getUrl(),
            'title'       => $node->getTitle() ?? '',
        ];
    }
}
