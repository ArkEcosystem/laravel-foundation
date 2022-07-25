<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Components\Kiosk\DeleteUser;
use ARKEcosystem\Foundation\Blog\Models\User;
use Livewire\Livewire;

it('should show the modal', function (): void {
    $user  = User::factory()->create();
    $other = User::factory()->create();

    $component = Livewire::actingAs($user)->test(DeleteUser::class);
    $component->call('open', $other->id);
    $component->assertSet('modalShown', true);
    $component->assertSet('user', fn ($property) => $property->is($other));
});

it('should hide the modal', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test(DeleteUser::class);
    $component->call('close');
    $component->assertSet('modalShown', false);
    $component->assertSet('user', null);
    $component->assertSet('userEmailConfirmation', null);
});

it('should reset any validation error when closing the modal', function (): void {
    $user = User::factory()->create();

    $other = User::factory()->create(['email' => 'john@example.com']);

    Livewire::actingAs($user)
        ->test(DeleteUser::class)
        ->call('open', $other->id)
        ->set('userEmailConfirmation', 'bar')
        ->assertHasErrors('userEmailConfirmation')
        ->call('close')
        ->assertSet('modalShown', false)
        ->assertSet('user', null)
        ->assertSet('userEmailConfirmation', null)
        ->assertHasNoErrors();
});

it('shows a validation error if email is not the same as the one user wants to delete', function (): void {
    $user = User::factory()->create();

    $other = User::factory()->create(['email' => 'john@example.com']);

    Livewire::actingAs($user)
        ->test(DeleteUser::class)
        ->call('open', $other->id)
        ->set('userEmailConfirmation', 'bar')
        ->assertHasErrors('userEmailConfirmation');
});

it('should not be able to submit if there is any validation error', function (): void {
    $user = User::factory()->create();

    $other = User::factory()->create(['email' => 'john@example.com']);

    $component = Livewire::actingAs($user)
        ->test(DeleteUser::class)
        ->call('open', $other->id)
        ->set('userEmailConfirmation', 'bar')
        ->assertHasErrors('userEmailConfirmation');

    expect($component->instance()->getCanSubmitProperty())->toBeFalse();
});

it('should be able to delete a user', function (): void {
    $user = User::factory()->create();

    $other = User::factory()->create(['email' => 'john@example.com']);

    $component = Livewire::actingAs($user)
        ->test(DeleteUser::class)
        ->call('open', $other->id)
        ->set('userEmailConfirmation', 'john@example.com')
        ->assertHasNoErrors();

    expect($component->instance()->getCanSubmitProperty())->toBeTrue();
    expect(User::count())->toBe(2);

    $component
        ->call('deleteUser')
        ->assertSet('modalShown', false)
        ->assertSet('user', null)
        ->assertSet('userEmailConfirmation', null)
        ->assertRedirect(route('kiosk.users'));

    expect(User::count())->toBe(1);
});
