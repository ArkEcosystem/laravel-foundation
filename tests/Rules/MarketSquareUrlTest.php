<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('marketsquare');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('marketsquare_url', $url));
})->with([
    'https://marketsquare.io/users/lilboatboy',
    'https://www.marketsquare.io/users/lilboatboy',
    'https://marketsquare.io/projects/lilboatboy',
    'https://www.marketsquare.io/projects/lilboatboy',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('marketsquare_url', $url))->toBeFalse();
})->with([
    'http://twiter.com/arkecosystem',
    'www.twiter.com/arkecosystem',
    'http://facebook.com/arkecosystem',
    'http://facebook.com/arkecosystem',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.custom.marketsquare_url'));
});
