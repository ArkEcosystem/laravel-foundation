<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies\Concerns;

trait HasDefaultPolicyRules
{
    public function viewAny(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'viewAny');
    }

    public function view(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'view');
    }

    public function create(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'create');
    }

    public function update(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'update');
    }

    public function delete(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'delete');
    }

    public function restore(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'restore');
    }

    public function forceDelete(mixed $user): bool
    {
        return $this->hasPermissionTo($user, 'forceDelete');
    }

    private function hasPermissionTo($user, string $action): bool
    {
        return $user->hasPermissionTo("{$action} {$this->resourceName}");
    }
}
