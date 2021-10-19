<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('telegram');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('telegram_url', $url));
})->with([
    'https://t.me/arkecosystem',
    'http://t.me/arkecosystem',
    'http://telegram.org/arkecosystem',
    'http://telegram.me/arkecosystem',
    'http://telegram.me/arkeco.system',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('telegram_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/arkecosystem',
    'arkecosystem',
    '/arkecosystem',
    'ftp://www.telegram.com/something',
    'www.telegram.com/arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.custom.telegram_url'));
});
