<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\User;
use ARKEcosystem\Foundation\Support\Timezone;
use Carbon\Carbon;

it('converts a date to the user timezone', function () {
    $this->actingAs(User::factory()->create(['timezone' => 'America/Mexico_City']));

    $date = Carbon::parse('2026-01-01 12:00:00', 'UTC');

    expect(Timezone::toLocal($date)->format('Y-m-d H:i'))->toBe('2026-01-01 06:00');
    expect($date->timezoneName)->toBe('UTC');
});

it('converts a local date to utc', function () {
    $this->actingAs(User::factory()->create(['timezone' => 'America/Mexico_City']));

    $date = Timezone::fromLocal('2026-01-01T06:00');

    expect($date->timezoneName)->toBe('UTC');
    expect($date->format('Y-m-d H:i'))->toBe('2026-01-01 12:00');
});

it('falls back to the app timezone for guests', function () {
    config(['app.timezone' => 'UTC']);

    expect(Timezone::fromLocal('2026-01-01T06:00')->format('Y-m-d H:i'))->toBe('2026-01-01 06:00');
});
