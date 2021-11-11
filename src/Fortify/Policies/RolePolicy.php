<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny($user)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function view($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can create the model.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create($user)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function update($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function delete($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function restore($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function forceDelete($user, Role $role)
    {
        return $this->isSuperAdmin($user);
    }

    private function isSuperAdmin($user): bool
    {
        return $user->hasRole([
            app(UserRole::class)::SUPER_ADMIN,
        ]);
    }
}
