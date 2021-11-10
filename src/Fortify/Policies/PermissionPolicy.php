<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Models\Permission;
use ARKEcosystem\Foundation\Fortify\Models\User;
use ARKEcosystem\Foundation\Fortify\Support\Enums\UserRole;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function view(User $user, Permission $permission)
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
    public function create(User $user)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function update(User $user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function delete(User $user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function restore(User $user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function forceDelete(User $user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    private function isSuperAdmin(User $user): bool
    {
        return $user->hasRole([
            UserRole::SUPER_ADMIN,
        ]);
    }
}
