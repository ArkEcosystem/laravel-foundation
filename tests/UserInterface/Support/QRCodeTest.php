<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Support\QRCode;

it('should generate an SVG', function () {
    expect(QRCode::generate('ark:AdVSe37niA3uFUPgCgMUH2tMsHF4LpLoiX'))->toBeString();
    expect(QRCode::generate('ark:AdVSe37niA3uFUPgCgMUH2tMsHF4LpLoiX'))->toContain('<svg');
});
