<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Support\Services;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use ARKEcosystem\Foundation\Fortify\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

final class PermissionMapping
{
    public static function all(): array
    {
        $roles = json_decode((string) file_get_contents(database_path('seeders/app/permissions.json')), true)['roles'];

        $permissions = [];
        foreach (array_keys($roles) as $role) {
            $permissions[$role] = [];

            foreach ($roles[$role] as $resource => $actions) {
                foreach ($actions as $action) {
                    $permissions[$role][] = "{$action} {$resource}";
                }
            }
        }

        return $permissions;
    }

    public static function mapToRoles(): void
    {
        $permissionMapping = static::all();
        $permissions       = Permission::all()->keyBy('name');

        foreach (Role::all() as $role) {
            /** @var \stdClass $role */
            if (! array_key_exists($role->name, $permissionMapping)) {
                continue;
            }

            $toInsert = collect();
            if ($role->name === app(UserRole::class)::SUPER_ADMIN->value) {
                $toInsert = $permissions;
            } else {
                $toInsert = $permissions->whereIn('name', $permissionMapping[$role->name]);
            }

            DB::table('role_has_permissions')->insert(collect($toInsert)->map(fn ($permission) => [
                'role_id'       => $role->id,
                'permission_id' => $permission->id,
            ])->toArray());
        }
    }
}
