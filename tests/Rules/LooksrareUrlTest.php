<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('looksrare');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('looksrare_url', $url));
})->with([
    'https://looksrare.org/collections/0x60E4d786628Fea6478F785A6d7e704777c86a7c6',
    'https://looksrare.org/accounts/0xEAc80aD5AA9d5e4316d90B7Fe78eD9EBdcDe0852',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('looksrare_url', $url))->toBeFalse();
})->with([
    'https://looksrare.org/collections/@0x60E4d786628Fea6478F785A6d7e704777c86a7c6',
    'https://looksrare.org/0xEAc80aD5AA9d5e4316d90B7Fe78eD9EBdcDe0852',
    '0xEAc80aD5AA9d5e4316d90B7Fe78eD9EBdcDe0852',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.looksrare_url'));
});
