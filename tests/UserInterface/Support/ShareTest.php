<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Support\Share;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('shares url', function (string $service) {
    assertMatchesSnapshot(
        call_user_func_safe([Share::page('https://blog.my-website.com', 'Awesome Article'), $service])
    );
})->with(['facebook', 'reddit', 'twitter']);
