<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Facades;

use Illuminate\Support\Facades\Facade;

class UserRole extends Facade
{
    protected static function getFacadeAccessor() { 
        return 'user-role'; 
    }
}
