<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\LogoutOtherBrowserSessionsForm;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;
use function Pest\Livewire\livewire;
use function Tests\createBrowserSessionForUser;
use function Tests\createUserModel;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function(){
    $this->user = createUserModel();
    Config::set('session.driver', 'database');
});

it('can interact with the form', function () {
    Livewire::actingAs($this->user)
        ->test(LogoutOtherBrowserSessionsForm::class);
});

it("shows only 3 browser sessions", function (){

    createBrowserSessionForUser('1.1.1.1', $this->user, now()->subHours(1)->unix());
    createBrowserSessionForUser('2.2.2.2', $this->user, now()->subHours(2)->unix());
    createBrowserSessionForUser('3.3.3.3', $this->user, now()->subHours(6)->unix());
    createBrowserSessionForUser('4.4.4.4', $this->user, now()->subHours(3)->unix());

    livewire(LogoutOtherBrowserSessionsForm::class)
        ->assertSee('1.1.1.1')
        ->assertSee('2.2.2.2')
        ->assertDontSee('3.3.3.3')
        ->assertSee('4.4.4.4')
    ;
});

it("removes all other browser sessions for this user", function (){
    
});