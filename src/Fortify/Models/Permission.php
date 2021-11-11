<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Nova\Nova;
use Spatie\Permission\Models\Permission as SpatieModel;

class Permission extends SpatieModel
{
    public static function getCacheKey(string $name, string $guardName): string
    {
        return sprintf('permissions:%s:%s', $name, $guardName);
    }

    public function scopeNovaResources(Builder $query): Builder
    {
        $resources =  collect(Nova::$resources)
            ->filter(fn (string $resource) => str_starts_with($resource, 'App\\Nova\\'))
            ->map(fn ($resource)           => Str::of($resource)->after('App\\Nova\\')->lower()->plural())
            ->sort()
            ->values();

        $order = $resources
            ->map(fn ($resource, $index) => "WHEN name like '% $resource' THEN $index")
            ->join(' ');

        return $query
            ->where(fn ($query) => $resources->each(fn ($resource) => $query->orWhere('name', 'like', '% '.$resource)))
            ->orderByRaw("CASE $order END ASC")
            ->orderBy('name');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updating(function ($permission) : void {
            $cachekey = static::getCacheKey($permission->getOriginal('name'), $permission->getOriginal('guard_name'));
            Cache::forget($cachekey);
        });

        static::deleted(function ($permission) : void {
            $cachekey = static::getCacheKey($permission->name, $permission->guard_name);
            Cache::forget($cachekey);
        });

        static::created(function ($permission) : void {
            $cachekey = static::getCacheKey($permission->name, $permission->guard_name);
            Cache::forget($cachekey);
        });
    }
}
