<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('tiktok');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('tiktok_url', $url));
})->with([
    'https://www.tiktok.com/@msq',
    'https://tiktok.com/@msq',
    'https://tiktok.com/@msq?lang=en',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('tiktok_url', $url))->toBeFalse();
})->with([
    'https://tiktok.com/msq',
    '@msq',
    'msq',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.tiktok_url'));
});
