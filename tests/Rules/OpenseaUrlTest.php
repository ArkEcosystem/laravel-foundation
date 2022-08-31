<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('opensea');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('opensea_url', $url));
})->with([
    'https://opensea.io/collection/boredapeyachtclub',
    'https://opensea.io/AVDR3W_OTC',
    'https://opensea.io/0xA8fd8582A93D9Dc547E3D48a0a4C2fDd938A2316',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('opensea_url', $url))->toBeFalse();
})->with([
    'https://opensea.io/@boredapeyachtclub',
    '@boredapeyachtclub',
    'boredapeyachtclub',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.opensea_url'));
});
