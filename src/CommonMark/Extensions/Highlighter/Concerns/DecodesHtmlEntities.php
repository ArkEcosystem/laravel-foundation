<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Highlighter\Concerns;

use League\CommonMark\Node\Node;
use League\CommonMark\Util\Html5EntityDecoder;

trait DecodesHtmlEntities
{
    private function parseEncodedHtml(Node $node): Node
    {
        $content        = $node->getLiteral();
        $hasEncodedHtml = preg_match_all('/&(\w+|\d+);/', $content, $matches);
        if ($hasEncodedHtml === false || $hasEncodedHtml === 0) {
            return $node;
        }

        $entitiesToUpdate = [];
        foreach (array_unique($matches[0]) as $element) {
            $entitiesToUpdate[$element] = Html5EntityDecoder::decode($element);
        }

        $content = str_replace(array_keys($entitiesToUpdate), $entitiesToUpdate, $content);

        $node->setLiteral($content);

        return $node;
    }
}
