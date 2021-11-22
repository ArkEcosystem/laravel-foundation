<?php

declare(strict_types=1);

namespace Tests\Analysis;

use GrahamCampbell\Analyzer\AnalysisTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class AnalysisTest extends TestCase
{
    use AnalysisTrait;

    public function getPaths(): array
    {
        return [
            __DIR__.'/../../src',
            __DIR__.'/../../tests',
        ];
    }

    public function getIgnored(): array
    {
        return [
            'Tests\createUserModel',
            'Tests\createAttributes',
            'Tests\createViewAttributes',
            'Tests\expectValidationError',
            'Tests\createBrowserSessionForUser',
            'Spatie\Snapshots\assertMatchesSnapshot',
            // TODO
            'ResolverFactoryTest',
            'Tests\Components\RegisterFormTest',
            'Pest\Laravel\actingAs',
            'Pest\Livewire\livewire',
        ];
    }
}
