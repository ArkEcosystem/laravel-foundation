<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Foundation\Fortify\Components\DeleteUserForm;
use ARKEcosystem\Foundation\Fortify\Contracts\DeleteUser;
use ARKEcosystem\Foundation\Fortify\Mail\SendFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    Route::get('/', fn () => [])->name('home');

    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('ui::pages.user-settings.delete_account_description'))
        ->set('confirmedPassword', 'password')
        ->call('deleteUser')
        ->assertRedirect('/');

    $this->assertNull(Auth::user());
});

it('can interact with the form and leave a feedback', function () {
    Mail::fake();

    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('ui::pages.user-settings.delete_account_description'))
        ->set('confirmedPassword', 'password')
        ->set('feedback', 'my feedback here')
        ->call('deleteUser')
        ->assertRedirect(URL::temporarySignedRoute('profile.feedback.thank-you', now()->addMinutes(15)));
    $this->assertNull(Auth::user());

    Mail::assertQueued(SendFeedback::class, function ($mail) {
        return $mail->hasTo(config('fortify.mail.feedback.address')) &&
            $mail->message === 'my feedback here';
    });
});

it('cant delete user with an incorrect password', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('ui::pages.user-settings.delete_account_description'))
        ->call('deleteUser')
        ->set('confirmedPassword', 'invalid-password')
        ->call('deleteUser');
    $this->assertNotNull(Auth::user());
});

it('clears the error when updating the value', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('ui::pages.user-settings.delete_account_description'))
        ->set('confirmedPassword', 'invalid-password')
        ->set('feedback', 'ab')
        ->call('deleteUser')
        ->assertHasErrors('confirmedPassword')
        ->assertHasErrors('feedback')
        ->set('confirmedPassword', 'updted-password')
        ->set('feedback', 'abcde')
        ->assertHasNoErrors();

    $this->assertNotNull(Auth::user());
});

it('cant delete user without a password', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->assertViewIs('ark-fortify::profile.delete-user-form')
        ->call('confirmUserDeletion')
        ->assertSee(trans('ui::pages.user-settings.delete_account_description'))
        ->call('deleteUser');

    $this->assertNotNull(Auth::user());
});

it('displays alert when set', function () {
    $user = createUserModel();

    $this->mock(DeleteUser::class)
        ->shouldReceive('delete');

    Livewire::actingAs($user)
        ->test(DeleteUserForm::class)
        ->set('modalShown', true)
        ->assertDontSee('alert-wrapper')
        ->set('alert', '<strong>a test alert</strong>with <a href="#">html</a>.')
        ->assertSee('alert-wrapper');
});
