<?php

namespace Tests\UserInterface\Livewire;

use Livewire\Component;

class DummyComponent extends Component
{
    public $listeners = [
        'dummy' => 'doSomething',
    ];

    public function doSomething()
    {
        //
    }
}
