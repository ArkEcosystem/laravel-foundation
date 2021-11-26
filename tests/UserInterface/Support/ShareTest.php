<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Support\Share;
use function Spatie\Snapshots\assertMatchesTextSnapshot;

it('shares url', function (string $service) {
    assertMatchesTextSnapshot(
        call_user_func_safe([Share::page('url', 'title'), $service])
    );
})->with(['facebook', 'reddit', 'twitter']);
