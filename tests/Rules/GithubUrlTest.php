<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('github');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('github_url', $url));
})->with([
    'https://github.com/arkecosystem/socials',
    'http://github.com/arkecosystem/socials',
    'http://www.github.com/arkecosystem',
    'https://github.com/arkecosystem',
    'https://github.com/arkecosystem?somethig=1',
    'https://github.com/arkecosystem/',
    'https://github.com/ArkEcosystem/marketsquare.io',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('github_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/arkecosystem',
    'arkecosystem',
    '/arkecosystem',
    'ftp://www.github.com/something',
    'www.github.com/arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.custom.github_url'));
});
