<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

abstract class Policy
{
    protected string $resourceName;

    public function viewAny(mixed $user): bool
    {
        return $user->hasPermissionTo("viewAny {$this->resourceName}");
    }

    public function view(mixed $user, mixed $model): bool
    {
        return $user->hasPermissionTo("view {$this->resourceName}");
    }

    public function create(mixed $user): bool
    {
        return $user->hasPermissionTo("create {$this->resourceName}");
    }

    public function update(mixed $user, mixed $model): bool
    {
        return $user->hasPermissionTo("update {$this->resourceName}");
    }

    public function delete(mixed $user, mixed $model): bool
    {
        return $user->hasPermissionTo("delete {$this->resourceName}");
    }

    public function restore(mixed $user, mixed $model): bool
    {
        return $user->hasPermissionTo("restore {$this->resourceName}");
    }

    public function forceDelete(mixed $user, mixed $model): bool
    {
        return $user->hasPermissionTo("forceDelete {$this->resourceName}");
    }
}
