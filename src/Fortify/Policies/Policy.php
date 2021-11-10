<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Models\User;

abstract class Policy
{
    protected string $resourceName;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo("viewAny {$this->resourceName}");
    }

    public function view(User $user, $model): bool
    {
        return $user->hasPermissionTo("view {$this->resourceName}");
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo("create {$this->resourceName}");
    }

    public function update(User $user, $model): bool
    {
        return $user->hasPermissionTo("update {$this->resourceName}");
    }

    public function delete(User $user, $model): bool
    {
        return $user->hasPermissionTo("delete {$this->resourceName}");
    }

    public function restore(User $user, $model): bool
    {
        return $user->hasPermissionTo("restore {$this->resourceName}");
    }

    public function forceDelete(User $user, $model): bool
    {
        return $user->hasPermissionTo("forceDelete {$this->resourceName}");
    }
}
