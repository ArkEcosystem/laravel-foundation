<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Console\Playbooks;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use ARKEcosystem\Foundation\Fortify\Models\Permission;
use ARKEcosystem\Foundation\Fortify\Support\Services\PermissionMapping;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AccessControlPlaybook extends Playbook
{
    private $actions = [
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
        'restore',
        'forceDelete',
    ];

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $resources = json_decode((string) file_get_contents(database_path('seeders/app/permissions.json')), true)['resources'];

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (app(UserRole::class)::toArray() as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $guardName   = Guard::getDefaultName(Permission::class);
        $permissions = collect();
        foreach ($this->actions as $action) {
            foreach ($resources as $resource) {
                $permissions->add([
                    'name'       => "{$action} {$resource}",
                    'guard_name' => $guardName,
                ]);
            }
        }

        Permission::upsert($permissions->toArray(), ['id']);

        PermissionMapping::mapToRoles();
    }
}
