<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Nova\Fields;

use ARKEcosystem\Foundation\Fortify\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Permission\Traits\HasPermissions;
use Vyuldashev\NovaPermission\PermissionBooleanGroup as NVyuldashevPermissionPermissionBooleanGroup;

final class PermissionBooleanGroup extends NVyuldashevPermissionPermissionBooleanGroup
{
    public function __construct($name, $attribute = null, callable $resolveCallback = null, $labelAttribute = null)
    {
        parent::__construct(
            $name,
            $attribute,
            $resolveCallback,
            $labelAttribute,
        );

        $options = Permission::novaResources()->pluck($labelAttribute ?? 'name', 'name')->toArray();

        $this->options($options);
    }

    /**
     * @param NovaRequest    $request
     * @param string         $requestAttribute
     * @param HasPermissions $model
     * @param string         $attribute
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $currentPermissions = $model->permissions;

        parent::fillAttributeFromRequest($request, $requestAttribute, $model, $attribute);

        $model->permissions->each(function ($permission) {
            $cachekey = Permission::getCacheKey($permission->name, $permission->guard_name);
            Cache::forget($cachekey);
        });

        $currentPermissions->each(function ($permission) {
            $cachekey = Permission::getCacheKey($permission->name, $permission->guard_name);
            Cache::forget($cachekey);
        });
    }
}
