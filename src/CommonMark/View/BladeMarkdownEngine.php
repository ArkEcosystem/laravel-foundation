<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\View;

use ARKEcosystem\Foundation\CommonMark\View\Engine\PathEvaluationTrait;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Engines\CompilerEngine;
use League\CommonMark\MarkdownConverterInterface;

final class BladeMarkdownEngine extends CompilerEngine
{
    use PathEvaluationTrait;

    /**
     * The markdown instance.
     *
     * @var MarkdownConverterInterface
     */
    private $markdown;

    /**
     * Create a new instance.
     *
     * @param CompilerInterface  $compiler
     * @param MarkdownConverterInterface $markdown
     *
     * @return void
     */

    /** @phpstan-ignore-next-line */
    public function __construct(CompilerInterface $compiler, MarkdownConverterInterface $markdown)
    {
        $this->compiler = $compiler;
        $this->markdown = $markdown;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param string $path
     * @param array  $data
     *
     * @return string
     */
    public function get($path, array $data = [])
    {
        $contents = parent::get($path, $data);

        if (Str::startsWith($contents, '---')) {
            $contents = trim(preg_replace('|^---[\s\S]+?---|', '', $contents));
        }

        return $this->markdown->convertToHtml($contents);
    }

    /**
     * Return the markdown instance.
     *
     * @return MarkdownConverterInterface
     */
    public function getMarkdown()
    {
        return $this->markdown;
    }
}
