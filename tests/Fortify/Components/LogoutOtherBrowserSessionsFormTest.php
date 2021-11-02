<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\LogoutOtherBrowserSessionsForm;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(LogoutOtherBrowserSessionsForm::class);
});
