<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support\Services;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;

final class CacheStore
{
    /**
     * @return mixed
     */
    public function minute(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addMinute());
    }

    /**
     * @return mixed
     */
    public function fiveMinutes(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addMinutes(5));
    }

    /**
     * @return mixed
     */
    public function tenMinutes(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addMinutes(10));
    }

    /**
     * @return mixed
     */
    public function fifteenMinutes(string $key, Closure $callback, array $tags = [])
    {
        return $this->remember($key, $callback, Carbon::now()->addMinutes(15), $tags);
    }

    /**
     * @return mixed
     */
    public function thirtyMinutes(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addMinutes(30));
    }

    /**
     * @return mixed
     */
    public function hour(string $key, Closure $callback, array $tags = [])
    {
        return $this->remember($key, $callback, Carbon::now()->addHour(), $tags);
    }

    /**
     * @return mixed
     */
    public function twoHours(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addHours(2));
    }

    /**
     * @return mixed
     */
    public function sixHours(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addHours(6));
    }

    /**
     * @return mixed
     */
    public function day(string $key, Closure $callback)
    {
        return $this->remember($key, $callback, Carbon::now()->addDay());
    }

    /**
     * @return mixed
     */
    public function rememberForever(string $key, Closure $callback, array $tags = [])
    {
        if (count($tags) > 0) {
            return Cache::tags($tags)->rememberForever($key, $callback);
        }

        return Cache::rememberForever($key, $callback);
    }

    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    /**
     * @return mixed
     */
    private function remember(string $key, Closure $callback, Carbon $ttl, array $tags = [])
    {
        if (count($tags) > 0) {
            return Cache::tags($tags)->remember($key, $ttl, $callback);
        }

        return Cache::remember($key, $ttl, $callback);
    }
}
