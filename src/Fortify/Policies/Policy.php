<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

abstract class Policy
{
    protected string $resourceName;

    public function viewAny($user): bool
    {
        return $user->hasPermissionTo("viewAny {$this->resourceName}");
    }

    public function view($user, $model): bool
    {
        return $user->hasPermissionTo("view {$this->resourceName}");
    }

    public function create($user): bool
    {
        return $user->hasPermissionTo("create {$this->resourceName}");
    }

    public function update($user, $model): bool
    {
        return $user->hasPermissionTo("update {$this->resourceName}");
    }

    public function delete($user, $model): bool
    {
        return $user->hasPermissionTo("delete {$this->resourceName}");
    }

    public function restore($user, $model): bool
    {
        return $user->hasPermissionTo("restore {$this->resourceName}");
    }

    public function forceDelete($user, $model): bool
    {
        return $user->hasPermissionTo("forceDelete {$this->resourceName}");
    }
}
