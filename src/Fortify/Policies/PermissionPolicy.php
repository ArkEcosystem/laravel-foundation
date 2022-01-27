<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use ARKEcosystem\Foundation\Fortify\Models\Permission;

class PermissionPolicy
{
    public function viewAny($user)
    {
        return $this->isSuperAdmin($user);
    }

    public function view($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function create($user)
    {
        return $this->isSuperAdmin($user);
    }

    public function update($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function delete($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function restore($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function forceDelete($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    private function isSuperAdmin($user): bool
    {
        return $user->hasRole([
            app(UserRole::class)::SUPER_ADMIN->value,
        ]);
    }
}
