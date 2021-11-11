<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

class UserPolicy extends Policy
{
    protected string $resourceName = 'users';

    public function delete($user, $model): bool
    {
        /** @var User $model */
        if ($user->id === $model->id) {
            return false;
        }

        return parent::delete($user, $model);
    }

    public function create($user): bool
    {
        return false;
    }
}
