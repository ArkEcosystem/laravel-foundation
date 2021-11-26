<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support;

final class Share
{
    public function __construct(
        private ?string $url = null,
        private ?string $title = null
    ) {
    }

    public static function page(string $url, ?string $title = null): self
    {
        return new static($url, $title);
    }

    public function facebook(): string
    {
        $base = config('share.services.facebook.uri');

        return $this->buildLink($base, [
            'u' => $this->url,
        ]);
    }

    public function twitter(): string
    {
        if (is_null($this->title)) {
            $this->title = config('laravel-share.services.twitter.text');
        }

        $base = config('share.services.twitter.uri');

        return $this->buildLink($base, [
            'text' => urlencode($this->title),
            'url'  => $this->url,
        ]);
    }

    public function reddit(): string
    {
        if (is_null($this->title)) {
            $this->title = config('laravel-share.services.reddit.text');
        }

        $base = config('laravel-share.services.reddit.uri');

        return $this->buildLink($base, [
            'title' => urlencode($this->title),
            'url'   => $this->url,
        ]);
    }

    private function buildLink(string $url, array $option): string
    {
        return urldecode($url.'?'.http_build_query($option));
    }
}
