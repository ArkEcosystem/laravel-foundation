<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\User;
use ARKEcosystem\Foundation\Rules\UniqueCaseInsensitive;

beforeEach(function (): void {
    $this->subject = new UniqueCaseInsensitive(User::class, 'username');
});

it('should pass with unique data', function () {
    User::factory()->create(['username' => 'johndoe']);

    expect($this->subject->passes(null, 'janedoe'))->toBeTrue();
});

it('should include trashed data', function () {
    $user = User::factory()->create(['username' => 'johndoe']);
    $user->delete();

    expect($this->subject->withTrashed()->passes(null, 'johndoe'))->toBeFalse();
});

it('should exclude trashed data by default', function () {
    $user = User::factory()->create(['username' => 'johndoe']);
    $user->delete();

    expect($this->subject->passes(null, 'johndoe'))->toBeTrue();
});

it('should exclude specified data', function () {
    $user = User::factory()->create(['username' => 'johndoe']);

    expect($this->subject->except('johndoe')->passes(null, 'johndoe'))->toBeTrue();
});

it('should fail with duplicate data', function () {
    User::factory()->create(['username' => 'johndoe']);

    expect($this->subject->passes(null, 'johndoe'))->toBeFalse();
});

it('should fail with duplicate case insensitive data', function () {
    User::factory()->create(['username' => 'johndoe']);

    expect($this->subject->passes(null, 'johnDOE'))->toBeFalse();
});

it('should return validation message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.messages.unique_case_insensitive'));
});
