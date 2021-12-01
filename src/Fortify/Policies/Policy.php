<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;

    protected string $resourceName;
}
