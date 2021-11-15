<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support;

use Illuminate\Support\Str;

/*
 * Some email clients will parse the content for urls, so they can convert them to <a> tags for convenience.
 * Since some emails contain user entered data, we have no control over these links, we don't like this because of
 * security issues. With this Class we can check if parts of the string matches an url notation (with or without
 * http(s)) and add an invisible extra period, so they won't be seen as url.
 *
 * This class is available through a Str macro: \Str::transformUrlsInvisibly($string, $attributes);
 */
final class TransformUrlsInvisibly
{
    public function __construct(protected string $value)
    {
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
                Str::replace('.', '<span style="display: none;">.</span>.', $match),
                $this->value
            );
        }

        return $this->value;
    }
}
