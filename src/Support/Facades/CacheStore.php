<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support\Facades;

use ARKEcosystem\Foundation\Support\Services\CacheStore as Service;
use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * @method static self minute(string $key, Closure $callback)
 * @method static self fiveMinutes(string $key, Closure $callback)
 * @method static self tenMinutes(string $key, Closure $callback)
 * @method static self fifteenMinutes(string $key, Closure $callback, array $tags = [])
 * @method static self thirtyMinutes(string $key, Closure $callback)
 * @method static self hour(string $key, Closure $callback, array $tags = [])
 * @method static self twoHours(string $key, Closure $callback)
 * @method static self sixHours(string $key, Closure $callback)
 * @method static self day(string $key, Closure $callback)
 * @method static self rememberForever(string $key, Closure $callback, array $tags = [])
 * @method static self forget(string $key): void
 *
 * @see \ARKEcosystem\Foundation\Support\Services\CacheStore
 */
final class CacheStore extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Service::class;
    }
}
