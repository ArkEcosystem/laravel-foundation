<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Policies\Concerns\HasDefaultPolicyRules;

class UserPolicy extends Policy
{
    use HasDefaultPolicyRules;

    protected string $resourceName = 'users';

    public function delete(mixed $user, mixed $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $this->hasPermissionTo($user, 'delete');
    }

    public function create($user): bool
    {
        return false;
    }
}
