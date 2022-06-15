<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support;

use DOMDocument;
use ErrorException;
use Illuminate\Support\Collection;

final class HtmlParser
{
    private DOMDocument $parser;

    public function __construct(string $html)
    {
        $this->parser = new DOMDocument;
        $this->html = $html;

        try {
            $this->parser->loadHtml($html);
        } catch (ErrorException) {
            // DOMDocument reports these exceptions whenever it founds any weird HTML error...
        }
    }

    /**
     * @return Collection<int, string>
     */
    public function links() : Collection
    {
        return collect($this->parser->getElementsByTagName('a'))->map(
            fn ($node) => trim($node->getAttribute('href'))
        );
    }
}
