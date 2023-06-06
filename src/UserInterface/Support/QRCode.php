<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\RendererStyle\Fill;

final class QRCode
{
    public static function generate(string $value, int $size = 250, ?Fill $fill = null): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(
                size: $size,
                margin: 1,
                fill: $fill,
            ),
            new SvgImageBackEnd(),
        );

        return (new Writer($renderer))->writeString($value);
    }
}
