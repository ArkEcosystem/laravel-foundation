<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('twitter');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('twitter_url', $url));
})->with([
    'http://twitter.com/#!/arkecosystem',
    'http://twitter.com/arkecosystem',
    'https://twitter.com/arkecosystem',
    'http://www.twitter.com/arkecosystem',
    'https://www.twitter.com/arkecosystem',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('twitter_url', $url))->toBeFalse();
})->with([
    'http://twiter.com/arkecosystem',
    'www.twiter.com/arkecosystem',
    'http://facebook.com/arkecosystem',
    'http://facebook.com/arkecosystem',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.twitter_url'));
});
