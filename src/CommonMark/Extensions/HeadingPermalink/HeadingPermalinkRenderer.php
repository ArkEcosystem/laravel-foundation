<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\HeadingPermalink;

use League\CommonMark\Extension\HeadingPermalink\HeadingPermalink;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

/**
 * Based on league/commonmark/src/Extension/HeadingPermalink/HeadingPermalinkRenderer.php
 * Only difference is the `$attrs->set('name', $slug);` line inside the `render` method.
 * Cannot be extended since is declared as final.
 */
final class HeadingPermalinkRenderer implements NodeRendererInterface, XmlNodeRendererInterface, ConfigurationAwareInterface
{
    public const DEFAULT_SYMBOL = '¶';

    private ConfigurationInterface $config;

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        HeadingPermalink::assertInstanceOf($node);

        $slug = $node->getSlug();

        $idPrefix = (string) $this->config->get('heading_permalink/id_prefix');
        if ($idPrefix !== '') {
            $idPrefix .= '-';
        }

        $fragmentPrefix = (string) $this->config->get('heading_permalink/fragment_prefix');
        if ($fragmentPrefix !== '') {
            $fragmentPrefix .= '-';
        }

        $attrs = $node->data->getData('attributes');
        $attrs->set('id', $idPrefix . $slug);
        // This line is the only difference from the original `league/commonmark`
        // renderer
        $attrs->set('name', $slug);
        $attrs->set('href', '#' . $fragmentPrefix . $slug);
        $attrs->append('class', $this->config->get('heading_permalink/html_class'));
        $attrs->set('aria-hidden', 'true');
        $attrs->set('title', $this->config->get('heading_permalink/title'));

        $symbol = $this->config->get('heading_permalink/symbol');
        \assert(\is_string($symbol));

        return new HtmlElement('a', $attrs->export(), \htmlspecialchars($symbol), false);
    }

    public function getXmlTagName(Node $node): string
    {
        return 'heading_permalink';
    }

    public function getXmlAttributes(Node $node): array
    {
        HeadingPermalink::assertInstanceOf($node);

        return [
            'slug' => $node->getSlug(),
        ];
    }
}
