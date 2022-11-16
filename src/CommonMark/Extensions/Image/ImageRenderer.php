<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

use Illuminate\Support\Facades\Http;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;
use ARKEcosystem\Foundation\CommonMark\Contracts\ImageDimensionsStrategy;

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

        $nodeUrl = $node->getUrl();

        $forbidUnsafeLinks = $this->config->get('allow_unsafe_links', true) !== true;
        if ($forbidUnsafeLinks && RegexHelper::isLinkPotentiallyUnsafe($nodeUrl)) {
            $attrs['src'] = '';
        } elseif (config('markdown.lazyload_images', false) === true) {
            $attrs['lazy'] = $nodeUrl;
        } else {
            $attrs['src'] = $nodeUrl;
        }

        $alt          = $childRenderer->renderNodes($node->children());
        $alt          = \preg_replace('/\<[^>]*alt="([^"]*)"[^>]*\>/', '$1', $alt);
        $attrs['alt'] = \preg_replace('/\<[^>]*\>/', '', $alt);

        /* @phpstan-ignore-next-line */
        if (($title = $node->getTitle()) !== null) {
            $attrs['title'] = $title;
        }

        $url = MediaUrlParser::parse($nodeUrl);

        if ($url !== null) {
            if ($url->isSimpleCast()) {
                $content = SimpleCastRenderer::render($url);
            } elseif ($url->isTwitter()) {
                $content = TwitterRenderer::render($url);
            } elseif ($url->isYouTube()) {
                $content = YouTubeRenderer::render($url);
            } else {
                $content = new HtmlElement('img', $this->addDimensions($attrs, $nodeUrl), '', true);
            }
        } else {
            $content = new HtmlElement('img', $this->addDimensions($attrs, $nodeUrl), '', true);
        }

        return ContainerRenderer::render($content, $attrs['alt']);
    }

    private function addDimensions(array $attrs, string $url): array
    {
        $service = config('markdown.image_dimensions_strategy');

        if ($service !== null) {
            $getDimensionsService = new $service;

            if ($getDimensionsService instanceof ImageDimensionsStrategy) {
                $dimensions = $getDimensionsService::getDimensionsFromUrl($url);

                if ($dimensions !== null) {
                    $attrs['width']  = $dimensions['width'];
                    $attrs['height'] = $dimensions['height'];
                }
            } else {
                throw new \Exception('The image dimensions strategy must implement the ImageDimensionsStrategy interface.');
            }
        }

        return $attrs;
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
