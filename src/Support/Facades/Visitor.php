<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support\Facades;

use ARKEcosystem\Foundation\Support\Services\Visitor as Service;
use Illuminate\Support\Facades\Facade;

/**
 * @method static self isEuropean()
 *
 * @see \ARKEcosystem\Foundation\Support\Services\Visitor
 */
class Visitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Service::class;
    }
}
