<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Nova\Fields;

use ARKEcosystem\Foundation\Fortify\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Permission\Traits\HasPermissions;
use Vyuldashev\NovaPermission\RoleBooleanGroup as NVyuldashevRoleBooleanGroup;

final class RoleBooleanGroup extends NVyuldashevRoleBooleanGroup
{
    /**
     * @param NovaRequest    $request
     * @param string         $requestAttribute
     * @param HasPermissions $model
     * @param string         $attribute
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        parent::fillAttributeFromRequest($request, $requestAttribute, $model, $attribute);

        $cachekey = Permission::getCacheKey($model->name, $model->guard_name);
        Cache::forget($cachekey);
    }
}
