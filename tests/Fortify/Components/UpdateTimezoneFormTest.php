<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\UpdateTimezoneForm;
use Livewire\Livewire;
use function Tests\createUserModel;

it('should have UTC as default timezone', function () {
    $this->actingAs(createUserModel());

    $this->assertDatabaseHas('users', [
        'timezone' => 'UTC',
    ]);

    Livewire::test(UpdateTimezoneForm::class)
        ->assertSet('timezone', 'UTC')
        ->assertSee('(UTC+00:00) UTC');
});

it('should not accept an invalid timezone', function () {
    $user = createUserModel();

    $this->actingAs($user);

    $this->assertDatabaseHas('users', [
        'timezone' => 'UTC',
    ]);

    Livewire::test(UpdateTimezoneForm::class)
        ->set('timezone', 'Invalid')
        ->call('updateTimezone')
        ->assertHasErrors('timezone');

    expect($user->fresh()->timezone)->toBe('UTC');
});

it('should be able to update the timezone', function () {
    $this->actingAs(createUserModel());

    $this->assertDatabaseHas('users', [
        'timezone' => 'UTC',
    ]);

    Livewire::test(UpdateTimezoneForm::class)
        ->assertSet('timezone', 'UTC')
        ->assertSee('(UTC+00:00) UTC')
        ->set('timezone', 'Europe/Amsterdam')
        ->call('updateTimezone')
        ->assertSet('timezone', 'Europe/Amsterdam')
        ->assertSee(') Europe/Amsterdam')
        ->assertEmitted('toastMessage', [trans('ui::pages.user-settings.timezone_updated'), 'success']);

    $this->assertDatabaseHas('users', [
        'timezone' => 'Europe/Amsterdam',
    ]);
});

it('should assert that the currentTimezone property is set to UTC by default and is a string', function () {
    $user = createUserModel();

    $this->actingAs($user);

    $realComponent = new UpdateTimezoneForm('1');
    $realComponent->mount();

    $this->assertSame('UTC', $realComponent->timezone);
    $this->assertSame($realComponent->timezone, $user->timezone);
});

it('can format a timezone', function () {
    $firstTimezone = 'America/Rainy_River';
    $firstFormattedTimezone = str_replace('_', ' ', $firstTimezone);

    $this->assertStringMatchesFormat('%s_%s', $firstTimezone);
    $this->assertStringMatchesFormat('%s %s', $firstFormattedTimezone);
    $this->assertSame('America/Rainy River', $firstFormattedTimezone);

    $secondTimezone = 'America/North_Dakota/New_Salem';
    $secondFormattedTimezone = str_replace('_', ' ', $secondTimezone);

    $this->assertStringMatchesFormat('%s_%s', $secondTimezone);
    $this->assertStringMatchesFormat('%s %s', $secondFormattedTimezone);
    $this->assertSame('America/North Dakota/New Salem', $secondFormattedTimezone);
});
