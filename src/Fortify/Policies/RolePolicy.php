<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny($user)
    {
        return $this->isSuperAdmin($user);
    }

    public function view($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    public function create($user)
    {
        return $this->isSuperAdmin($user);
    }

    public function update($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    public function delete($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    public function restore($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    public function forceDelete($user, Role $role)
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
