<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('bitbucket');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('facebook_url', $url));
})->with([
    'https://bitbucket.org/arkecosystem/socials',
    'https://bitbucket.com/arkecosystem/socials',
    'http://www.bitbucket.org/arkecosystem',
    'https://bitbucket.org/arkecosystem',
    'https://bitbucket.org/arkecosystem?somethig=1',
    'https://bitbucket.org/arkecosystem/',
    'https://bitbucket.org/arkecosystem/dailytask-15-07-2020/src/master/',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('bitbucket_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/arkecosystem',
    'arkecosystem',
    '/arkecosystem',
    'ftp://www.bitbucket.com/something',
    'www.bitbucket.com/arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.bitbucket_url'));
});
