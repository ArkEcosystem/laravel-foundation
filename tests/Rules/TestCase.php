<?php

declare(strict_types=1);

namespace Tests\Rules;

use ARKEcosystem\Foundation\Providers\HermesServiceProvider;
use ARKEcosystem\Foundation\Providers\MarkdownServiceProvider;
use ARKEcosystem\Foundation\Providers\RulesServiceProvider;
use ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\FortifyServiceProvider;
use Livewire\LivewireServiceProvider;
use Spatie\Honeypot\HoneypotServiceProvider;
use Spatie\Newsletter\NewsletterServiceProvider;
use Tests\TestCase as Base;

/**
 * @coversNothing
 */
class TestCase extends Base
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->loadMigrationsFrom(dirname(__DIR__).'/database/migrations');
        $this->loadMigrationsFrom(dirname(__DIR__).'/Blog/database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            // Third-Party
            FortifyServiceProvider::class,
            MarkdownServiceProvider::class,
            LivewireServiceProvider::class,
            HoneypotServiceProvider::class,
            // First-Party
            HermesServiceProvider::class,
            NewsletterServiceProvider::class,
            RulesServiceProvider::class,
            UserInterfaceServiceProvider::class,
        ];
    }

    protected function afterRefreshingDatabase()
    {
        $this->loadMigrationsFrom(dirname(__DIR__).'/database/migrations');
        $this->loadMigrationsFrom(dirname(__DIR__).'/Blog/database/migrations');
    }
}
