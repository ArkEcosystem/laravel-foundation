<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Markdown.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ARKEcosystem\Foundation\CommonMark\View\Engine;

use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Engines\CompilerEngine;
use League\CommonMark\MarkdownConverterInterface;

/**
 * This is the php markdown engine class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
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
