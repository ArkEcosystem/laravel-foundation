<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Support\Services;

use ARKEcosystem\Foundation\Fortify\Models\Permission;
use ARKEcosystem\Foundation\Support\Facades\CacheStore;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Spatie\Permission\PermissionRegistrar as PermissionPermissionRegistrar;

/**
 * @method \Spatie\Permission\Models\Permission getPermissionClass()
 */
final class PermissionRegistrar extends PermissionPermissionRegistrar
{
    public function getPermissions(array $params = [], bool $onlyOne = false): Collection
    {
        $cacheKey = Permission::getCacheKey(
            Arr::get($params, 'name', ''),
            Arr::get($params, 'guard_name', '')
        );

        return CacheStore::thirtyMinutes($cacheKey, function () use ($params, $onlyOne): Collection {
            $permission = $this->getPermissionClass();

            $query = $permission->with('roles');

            foreach ($params as $attr => $value) {
                $query->where((string) $attr, $value);
            }

            if ($onlyOne) {
                $query->limit(1);
                // return collect($query->get()->first());
            }

            return $query->get();
        });
    }
}
