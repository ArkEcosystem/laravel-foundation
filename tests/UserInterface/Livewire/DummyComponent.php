<?php

declare(strict_types=1);

namespace Tests\UserInterface\Livewire;

use Livewire\Component;

class DummyComponent extends Component
{
    public $listeners = [
        'dummy'        => 'doSomething',
        'anotherDummy' => 'doSomething',
    ];

    public function doSomething()
    {
        //
    }
}
