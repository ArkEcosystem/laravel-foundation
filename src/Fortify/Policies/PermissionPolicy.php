<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Contracts\UserRole;
use ARKEcosystem\Foundation\Fortify\Models\Permission;

class PermissionPolicy
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
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function view($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can create the model.
     *
     * @param $user
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
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function update($user, Permission $permission)
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
    public function delete($user, Permission $permission)
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
    public function restore($user, Permission $permission)
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
    public function forceDelete($user, Permission $permission)
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
