<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation\Concerns;

use ARKEcosystem\Foundation\UserInterface\Support\Share;

trait CanBeShared
{
    public function urlFacebook(): string
    {
        return Share::facebook($this->url());
    }

    public function urlReddit(?string $title = null): string
    {
        return Share::reddit($this->url(), $title);
    }

    public function urlTwitter(?string $title = null): string
    {
        return Share::twitter($this->url(), $title);
    }
}
