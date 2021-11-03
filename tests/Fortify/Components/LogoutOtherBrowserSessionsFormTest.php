<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\LogoutOtherBrowserSessionsForm;
use ARKEcosystem\Foundation\Fortify\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;
use function Tests\createBrowserSessionForUser;
use function Tests\createUserModel;

uses(RefreshDatabase::class);

beforeEach(function(){
    $this->user = createUserModel();
    Config::set('session.driver', 'database');
});

it('can interact with the form', function () {
    Livewire::actingAs($this->user)
        ->test(LogoutOtherBrowserSessionsForm::class);
});

it("shows only 3 browser sessions", function (){

    $session_1 = createBrowserSessionForUser('1.1.1.1', $this->user, now()->subHours(1)->unix());
    $session_2 = createBrowserSessionForUser('2.2.2.2', $this->user, now()->subHours(2)->unix());
    $session_3 = createBrowserSessionForUser('3.3.3.3', $this->user, now()->subHours(6)->unix());
    $session_4 = createBrowserSessionForUser('4.4.4.4', $this->user, now()->subHours(3)->unix());
    
    actingAs($this->user);
    
    Session::shouldReceive('getId')->andReturn($session_1);
    
    livewire(LogoutOtherBrowserSessionsForm::class)
        ->assertSee('1.1.1.1')
        ->assertSee('2.2.2.2')
        ->assertDontSee('3.3.3.3')
        ->assertSee('4.4.4.4');
});

it("removes all other browser sessions for this user", function (){
    $session_1 = createBrowserSessionForUser('1.1.1.1', $this->user, now()->subHours(1)->unix());
    $session_2 = createBrowserSessionForUser('2.2.2.2', $this->user, now()->subHours(2)->unix());
    $session_3 = createBrowserSessionForUser('3.3.3.3', $this->user, now()->subHours(6)->unix());
    $session_4 = createBrowserSessionForUser('4.4.4.4', $this->user, now()->subHours(3)->unix());
    
    actingAs($this->user);
    
    Session::shouldReceive('get');
    Session::shouldReceive('forget');
    Session::shouldReceive('getId')->andReturn($session_1);
    
    livewire(LogoutOtherBrowserSessionsForm::class)
        ->call('confirmLogout')
        ->assertSee('Logout Other Browser Sessions')
        ->set('password', 'password')
        ->call('logoutOtherBrowserSessions')
        ->assertSet('modalShown', false);
    
    $sessions = DB::table('sessions')->where('user_id', $this->user->id)->get();
    expect(count($sessions))->toBe(1);
    expect($sessions[0]->ip_address)->toBe('1.1.1.1');
});

it("should not delete browser sessions of other users", function (){
    $other_user = User::create([
        'name'              => 'John Doe 2',
        'username'          => 'john.doe.2',
        'email'             => 'john2@doe.com',
        'email_verified_at' => Carbon::now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'timezone'          => 'UTC',
    ]);
    
    $session_1 = createBrowserSessionForUser('1.1.1.1', $this->user, now()->subHours(1)->unix());
    $session_2 = createBrowserSessionForUser('2.2.2.2', $this->user, now()->subHours(2)->unix());
    $session_3 = createBrowserSessionForUser('3.3.3.3', $other_user, now()->subHours(6)->unix());
    
    actingAs($this->user);
    
    Session::shouldReceive('get');
    Session::shouldReceive('forget');
    Session::shouldReceive('getId')->andReturn($session_1);
    
    livewire(LogoutOtherBrowserSessionsForm::class)
        ->call('confirmLogout')
        ->assertSee('Logout Other Browser Sessions')
        ->set('password', 'password')
        ->call('logoutOtherBrowserSessions')
        ->assertSet('modalShown', false);
    
    $sessions = DB::table('sessions')->where('user_id', $this->user->id)->get();
    expect(DB::table('sessions')->where('user_id', $other_user->id)->count())->toBe(1);
});