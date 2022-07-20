<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\CommonMark\Extensions\HeadingPermalink\HeadingPermalinkRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\CodeRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\FencedCodeRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\IndentedCodeRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Image\ImageRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Link\LinkRenderer;
use ARKEcosystem\Foundation\CommonMark\Extensions\Node\Block\ImageWithRichCaption;
use ARKEcosystem\Foundation\CommonMark\Extensions\Parser\Block\ImageWithRichCaptionStartParser;
use ARKEcosystem\Foundation\CommonMark\Extensions\Parser\Inline\SVGParser;
use ARKEcosystem\Foundation\CommonMark\Extensions\Renderer\Block\ImageWithRichCaptionRenderer;
use ARKEcosystem\Foundation\CommonMark\View\BladeEngine;
use ARKEcosystem\Foundation\CommonMark\View\BladeMarkdownEngine;
use ARKEcosystem\Foundation\CommonMark\View\FileViewFinder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\HtmlBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Extension\CommonMark\Parser\Block\BlockQuoteStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Block\FencedCodeStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Block\HeadingStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Block\HtmlBlockStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Block\IndentedCodeStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Block\ThematicBreakStartParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\AutolinkParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BacktickParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BangParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\CloseBracketParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\EntityParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\EscapableParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\HtmlInlineParser;
use League\CommonMark\Extension\CommonMark\Parser\Inline\OpenBracketParser;
use League\CommonMark\Extension\CommonMark\Renderer\Block\BlockQuoteRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HeadingRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\HtmlBlockRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ListBlockRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ListItemRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ThematicBreakRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\EmphasisRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\HtmlInlineRenderer;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\StrongRenderer;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalink;
use League\CommonMark\MarkdownConverterInterface;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\Newline;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Normalizer\SlugNormalizer;
use League\CommonMark\Parser\Inline\NewlineParser;
use League\CommonMark\Renderer\Block\DocumentRenderer;
use League\CommonMark\Renderer\Block\ParagraphRenderer;
use League\CommonMark\Renderer\Inline\NewlineRenderer;
use League\CommonMark\Renderer\Inline\TextRenderer;

final class CommonMarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(MarkdownServiceProvider::class);

        $this->registerViewFinder();
    }

    /**
     * Boot services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPublishers();

        $this->registerBladeEngines();

        $this->registerCommonMarkEnvironment();
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        $this->publishes([
            __DIR__.'/../../config/markdown.php' => config_path('markdown.php'),
        ], 'config');
    }

    /**
     * Boot services.
     *
     * @return void
     */
    private function registerBladeEngines(): void
    {
        $this->app->view->getEngineResolver()->register('blade', function (): BladeEngine {
            return new BladeEngine($this->app['blade.compiler'], $this->app['files']);
        });

        $this->app->view->getEngineResolver()->register('blademd', function (): BladeMarkdownEngine {
            return new BladeMarkdownEngine($this->app['blade.compiler'], $this->app['markdown']);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    private function registerViewFinder(): void
    {
        $this->app->bind('view.finder', function ($app): FileViewFinder {
            return new FileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    private function registerCommonMarkEnvironment(): void
    {
        /** @var \League\CommonMark\Environment\Environment */
        $environment = app(MarkdownConverterInterface::class)->getEnvironment();

        $environment->addRenderer(FencedCode::class, new FencedCodeRenderer());
        $environment->addRenderer(HeadingPermalink::class, new HeadingPermalinkRenderer());

        $environment->addBlockStartParser(new BlockQuoteStartParser(), 70);
        $environment->addBlockStartParser(new HeadingStartParser(), 60);
        $environment->addBlockStartParser(new FencedCodeStartParser(), 50);
        $environment->addBlockStartParser(new HtmlBlockStartParser(), 40);
        $environment->addBlockStartParser(new HeadingStartParser(), 30);
        $environment->addBlockStartParser(new ThematicBreakStartParser(), 20);
        $environment->addBlockStartParser(new ImageWithRichCaptionStartParser(), 20);

        // $environment->addBlockStartParser(new ListParser(), 10);
        $environment->addBlockStartParser(new IndentedCodeStartParser(), -100);
        // $environment->addBlockStartParser(new ParagraphParser(), -200);

        $environment->addInlineParser(new NewlineParser(), 200);
        $environment->addInlineParser(new BacktickParser(), 150);
        $environment->addInlineParser(new EscapableParser(), 80);
        $environment->addInlineParser(new EntityParser(), 70);
        $environment->addInlineParser(new AutolinkParser(), 50);
        $environment->addInlineParser(new HtmlInlineParser(), 40);
        $environment->addInlineParser(new CloseBracketParser(), 30);
        $environment->addInlineParser(new OpenBracketParser(), 20);
        $environment->addInlineParser(new BangParser(), 10);
        $environment->addInlineParser(new SVGParser(), 10);

        $environment->addRenderer(BlockQuote::class, new BlockQuoteRenderer(), 0);
        $environment->addRenderer(Document::class, new DocumentRenderer(), 0);
        $environment->addRenderer(FencedCode::class, new FencedCodeRenderer(), 0);
        $environment->addRenderer(Heading::class, new HeadingRenderer(), 0);
        $environment->addRenderer(HtmlBlock::class, new HtmlBlockRenderer(), 0);
        $environment->addRenderer(IndentedCode::class, new IndentedCodeRenderer(), 0);
        $environment->addRenderer(ListBlock::class, new ListBlockRenderer(), 0);
        $environment->addRenderer(ListItem::class, new ListItemRenderer(), 0);
        $environment->addRenderer(Paragraph::class, new ParagraphRenderer(), 0);
        $environment->addRenderer(ThematicBreak::class, new ThematicBreakRenderer(), 0);

        $environment->addRenderer(Code::class, new CodeRenderer(), 0);
        $environment->addRenderer(Emphasis::class, new EmphasisRenderer(), 0);
        $environment->addRenderer(HtmlInline::class, new HtmlInlineRenderer(), 0);
        $environment->addRenderer(Image::class, new ImageRenderer(), 0);
        $environment->addRenderer(Newline::class, new NewlineRenderer(), 0);
        $environment->addRenderer(Strong::class, new StrongRenderer(), 0);
        $environment->addRenderer(Text::class, new TextRenderer(), 0);
        $environment->addRenderer(ImageWithRichCaption::class, new ImageWithRichCaptionRenderer(), 0);

        $inlineRenderers = array_merge([
            Code::class       => CodeRenderer::class,
            Emphasis::class   => EmphasisRenderer::class,
            HtmlInline::class => HtmlInlineRenderer::class,
            Image::class      => ImageRenderer::class,
            Link::class       => LinkRenderer::class,
            Newline::class    => NewlineRenderer::class,
            Strong::class     => StrongRenderer::class,
            Text::class       => TextRenderer::class,
        ], Config::get('markdown.inlineRenderers', []));

        foreach ($inlineRenderers as $interface => $implementation) {
            $environment->addRenderer($interface, resolve($implementation), 0);
        }

        foreach (Config::get('markdown.extensions', []) as $extension) {
            $environment->addExtension(resolve($extension));
        }

        $environment->mergeConfig(config('markdown.environment', [
            'external_link' => [
                'internal_hosts'     => config('app.url'),
                'open_in_new_window' => true,
                'html_class'         => 'external-link',
                'nofollow'           => '',
                'noopener'           => 'external',
                'noreferrer'         => 'external',
                'infix'              => ' ',
            ],
            'heading_permalink' => [
                'html_class'      => 'heading-permalink',
                'id_prefix'       => 'user-content',
                'insert'          => 'before',
                'title'           => 'Permalink',
                'symbol'          => '#',
            ],
            'slug_normalizer' => [
                'instance' => new SlugNormalizer(),
            ],
        ]));
    }
}
