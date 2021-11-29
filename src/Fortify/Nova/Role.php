<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Nova;

use ARKEcosystem\Foundation\Fortify\Nova\Fields\PermissionBooleanGroup;
use Illuminate\Http\Request;
use Vyuldashev\NovaPermission\PermissionBooleanGroup as VyuldashevPermissionBooleanGroup;
use Vyuldashev\NovaPermission\Role as VyuldashevRoleResource;

final class Role extends VyuldashevRoleResource
{
    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $fields = parent::fields($request);

        $fieldIndex = collect($fields)
            ->filter(fn ($field) => get_class($field) === VyuldashevPermissionBooleanGroup::class)
            ->keys()
            ->first();

        $fields[$fieldIndex] = PermissionBooleanGroup::make(__('nova-permission-tool::roles.permissions'), 'permissions');

        return $fields;
    }
}
