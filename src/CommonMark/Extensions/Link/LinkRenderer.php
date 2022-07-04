<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Link;

use Illuminate\Support\Arr;
use Illuminate\View\ComponentAttributeBag;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

final class LinkRenderer implements NodeRendererInterface, XmlNodeRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    private ConfigurationInterface $config;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable|string|null
    {
        Link::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');

        $forbidUnsafeLinks = ! $this->config->exists('allow_unsafe_links') || ! $this->config->get('allow_unsafe_links');
        if (! ($forbidUnsafeLinks && RegexHelper::isLinkPotentiallyUnsafe($node->getUrl()))) {
            $attrs['href'] = $this->getNodeUrl($node);
        }

        /* @phpstan-ignore-next-line */
        if (($title = $node->getTitle()) !== null) {
            $attrs['title'] = $title;
        }

        /* @phpstan-ignore-next-line */
        if (isset($attrs['target']) && $attrs['target'] === '_blank' && ! isset($attrs['rel'])) {
            $attrs['rel'] = 'noopener nofollow noreferrer';
        }

        $attrs = array_merge(Arr::only($attrs, ['href', 'id', 'class', 'name', 'title']), config('markdown.link_attributes', []));

        $content = $childRenderer->renderNodes($node->children());

        if (! $this->isInternalLink($attrs['href'])) {
            $attrs['target']        = '_blank';
            $attrs['data-external'] = 'true';

            $externalLinkIcon = view('ark::icon', array_merge(
                config('markdown.link_renderer_view_attributes', []),
                [
                    'attributes' => new ComponentAttributeBag([]),
                    'name'       => 'arrows.arrow-external',
                    'class'      => 'inline ml-1 -mt-1.5',
                    'size'       => 'sm',
                ]
            ));

            $content = $content.$this->config->get('external_link/infix').$externalLinkIcon->render();
        }

        return new HtmlElement('a', $attrs, $content);
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    public function getXmlTagName(Node $node): string
    {
        return 'link';
    }

    /**
     * @param Link $node
     *
     * @return array<string, scalar>
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function getXmlAttributes(Node $node): array
    {
        Link::assertInstanceOf($node);

        return [
            'destination' => $node->getUrl(),
            'title'       => $node->getTitle() ?? '',
        ];
    }

    private function getNodeUrl(Node $node): string
    {
        $url = $node->getUrl();

        $path = parse_url($url, PHP_URL_PATH);

        if ($this->pathIsADomain($path)) {
            return 'https://'.$path;
        }

        return $url;
    }

    private function pathIsADomain(?string $path): bool
    {
        if ($path === null) {
            return false;
        }

        // @see https://stackoverflow.com/questions/10306690/what-is-a-regular-expression-which-will-match-a-valid-domain-name-without-a-subd
        $regex = '/^(((?!-))(xn--|_{1,1})?[a-z0-9-]{0,61}[a-z0-9]{1,1}\.)*(xn--)?([a-z0-9-]{1,30}\.[a-z]{2,})/m';

        return preg_match($regex, $path) === 1;
    }

    private function isInternalLink(string $url): bool
    {
        if (str_starts_with($url, config('app.url'))) {
            return true;
        }

        // Anchors
        if (str_starts_with($url, '#')) {
            return true;
        }

        // Relative links, but not protocol relative
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        // Emails
        if (str_starts_with($url, 'mailto:')) {
            return true;
        }

        return false;
    }
}
