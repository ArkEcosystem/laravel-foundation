<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support;

use Illuminate\Support\Str;

/*
 * Some email clients will parse the content for urls, so they can convert them to a tags for convenience.
 * Since some emails contain user entered data we have no control over these links, we don't like this because of
 * security issues. With this Class we can check if parts of the string matches an url notation (with or without
 * http(s)).
 *
 * Since adding an a tag will change the styling, you can optionally add one or more attributes to adapt the styling
 * as an array where the index is the attribute and de value the value of the attribute.
 *
 * This class is available through a Str macro: \Str::wrapUrlsInBlankATag($string, $attributes);
 */
final class UrlInStringWrapper
{
    private array $attributes = [];

    public function __construct(protected string $value)
    {
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getString(): string
    {
        $pattern = '/[a-zA-Z0-9]*[\.\-\:].\S*/';

        preg_match_all($pattern, $this->value, $matches);

        if (count($matches[0]) === 0) {
            return $this->value;
        }

        foreach ($matches[0] as $index => $match) {
            $this->value = Str::replace(
                $match,
                '<a'.$this->attributesString().'>'.$match.'</a>',
                $this->value
            );
        }

        return $this->value;
    }

    private function attributesString(): string
    {
        if (count($this->attributes) === 0) {
            return '';
        }

        return ' '.collect($this->attributes)->map(function ($value, $attr) {
            return $attr.'="'.$value.'"';
        })->implode(' ');
    }
}
