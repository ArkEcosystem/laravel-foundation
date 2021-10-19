<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceName;

beforeEach(function (): void {
    $this->subject = new ServiceName('twitter');
});

it('validates a valid name', function ($name) {
    $this->assertTrue($this->subject->passes('twitter_name', $name));
})->with([
    'arkecosystem',
    '@arkecosystem',
    'ArkEcosystem',
    'ark_ecosystem',
    'ark-ecosystem',
]);

it('invalidates an invalid name', function ($name) {
    expect($this->subject->passes('twitter_name', $name))->toBeFalse();
})->with([
    'http://twiter.com/arkecosystem',
    'www.twiter.com/arkecosystem',
    '/arkecosystem',
    'ark.ecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.twitter_name'));
});
