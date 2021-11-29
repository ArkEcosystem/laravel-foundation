<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies\Concerns;

trait HasDefaultPolicyRules
{
    public function viewAny($user): bool
    {
        return $this->hasPermissionTo($user, 'viewAny');
    }

    public function view($user): bool
    {
        return $this->hasPermissionTo($user, 'view');
    }

    public function create($user): bool
    {
        return $this->hasPermissionTo($user, 'create');
    }

    public function update($user): bool
    {
        return $this->hasPermissionTo($user, 'update');
    }

    public function delete($user): bool
    {
        return $this->hasPermissionTo($user, 'delete');
    }

    public function restore($user): bool
    {
        return $this->hasPermissionTo($user, 'restore');
    }

    public function forceDelete($user): bool
    {
        return $this->hasPermissionTo($user, 'forceDelete');
    }

    private function hasPermissionTo($user, string $action): bool
    {
        return $user->hasPermissionTo("{$action} {$this->resourceName}");
    }
}
