<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Listeners;

use Illuminate\Auth\Events\Login;

final class UpdateUserTimezone
{
    public function handle(Login $event): void
    {
        $timezone = geoip()->getLocation(request()->ip())->timezone;

        if ($timezone === null || $event->user->timezone === $timezone) {
            return;
        }

        $event->user->forceFill(['timezone' => $timezone])->save();
    }
}
