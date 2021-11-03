<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Actions;

use ARKEcosystem\Foundation\Fortify\Contracts\DeleteUser as Contract;

final class DeleteUser implements Contract
{
    public function delete($user): void
    {
        $user->delete();
    }
}
