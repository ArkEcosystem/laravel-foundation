<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Listeners\UpdateUserTimezone;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Torann\GeoIP\GeoIP;
use Torann\GeoIP\Location;

function fakeGeoIpTimezone(?string $timezone): void
{
    $geoip = Mockery::mock(GeoIP::class);
    $geoip->shouldReceive('getLocation')->andReturn(new Location(['timezone' => $timezone]));

    app()->instance('geoip', $geoip);
}

it('is registered for the login event', function () {
    expect(Event::hasListeners(Login::class))->toBeTrue();
    expect(Event::getRawListeners()[Login::class])->toContain(UpdateUserTimezone::class);
});

it('updates the user timezone on login', function () {
    fakeGeoIpTimezone('Europe/Ljubljana');

    $user = User::factory()->create(['timezone' => 'UTC']);

    (new UpdateUserTimezone())->handle(new Login('web', $user, false));

    expect($user->fresh()->timezone)->toBe('Europe/Ljubljana');
});

it('does not touch the user when the timezone could not be resolved', function () {
    fakeGeoIpTimezone(null);

    $user = User::factory()->create(['timezone' => 'America/Mexico_City']);

    (new UpdateUserTimezone())->handle(new Login('web', $user, false));

    expect($user->fresh()->timezone)->toBe('America/Mexico_City');
});
