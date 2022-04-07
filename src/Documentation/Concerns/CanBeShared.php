<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation\Concerns;

use ARKEcosystem\Foundation\UserInterface\Support\Share;
use Illuminate\Support\Facades\Request;

trait CanBeShared
{
    public function urlFacebook(): string
    {
        return Share::facebook($this->url());
    }

    public function urlReddit(): string
    {
        return Share::reddit($this->url());
    }

    public function urlTwitter(): string
    {
        return Share::twitter($this->url());
    }
}
