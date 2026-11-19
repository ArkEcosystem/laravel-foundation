<?php

declare(strict_types=1);

namespace Tests\WithoutLivewire;

use ARKEcosystem\Foundation\Providers\BlogServiceProvider;
use ARKEcosystem\Foundation\Providers\FoundationServiceProvider;
use Tests\TestCase as Base;

/**
 * Boots foundation the way apps that don't use Livewire do (e.g. with
 * `livewire/livewire` in `dont-discover`), so Livewire's provider is never loaded.
 *
 * @coversNothing
 */
class TestCase extends Base
{
    protected function getPackageProviders($app)
    {
        return [
            FoundationServiceProvider::class,
            BlogServiceProvider::class,
        ];
    }
}
