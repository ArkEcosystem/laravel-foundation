<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;

final class Timezone
{
    public static function list(): array
    {
        return DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    }

    public static function formattedList(): array
    {
        $formattedList = collect(static::list())->map(function ($timezoneIdentifier) {
            $timezone = CarbonTimeZone::instance(new DateTimeZone($timezoneIdentifier));

            return [
                'offset'            => $timezone->getOffset(Carbon::now()),
                'timezone'          => $timezoneIdentifier,
                'formattedTimezone' => "(UTC{$timezone->toOffsetName()}) ".str_replace('_', ' ', $timezoneIdentifier),
            ];
        })->sortBy('offset')->toArray();

        return Cache::rememberForever('timezones', fn () => $formattedList);
    }
}
