<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use ARKEcosystem\Foundation\Fortify\Models\User;

class UserPolicy extends Policy
{
    protected string $resourceName = 'users';

    public function delete(User $user, $model): bool
    {
        /** @var User $model */
        if ($user->id === $model->id) {
            return false;
        }

        return parent::delete($user, $model);
    }

    public function create(User $user): bool
    {
        return false;
    }
}
