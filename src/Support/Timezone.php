<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

final class Timezone
{
    public static function list(): array
    {
        return DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    }

    public static function formattedList(): array
    {
        return Cache::rememberForever('timezones', fn () => collect(static::list())->map(function ($timezoneIdentifier) {
            $timezone = CarbonTimeZone::instance(new DateTimeZone($timezoneIdentifier));

            return [
                'offset'            => $timezone->getOffset(Carbon::now()),
                'timezone'          => $timezoneIdentifier,
                'formattedTimezone' => "(UTC{$timezone->toOffsetName()}) ".str_replace('_', ' ', $timezoneIdentifier),
            ];
        })->sortBy('offset')->toArray());
    }

    public static function toLocal(Carbon $date): Carbon
    {
        return $date->copy()->setTimezone(static::current());
    }

    public static function fromLocal(string $date): Carbon
    {
        return Carbon::parse($date, static::current())->setTimezone('UTC');
    }

    private static function current(): string
    {
        return Auth::user()?->timezone ?? Config::get('app.timezone');
    }
}
