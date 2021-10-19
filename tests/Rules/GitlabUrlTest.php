<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('gitlab');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('gitlab_url', $url));
})->with([
    'https://gitlab.com/arkecosystem/socials',
    'http://gitlab.com/arkecosystem/socials',
    'https://gitlab.com/a',
    'https://gitlab.com/a/c6',
    'http://www.gitlab.com/arkecosystem',
    'https://gitlab.com/arkecosystem',
    'https://gitlab.com/arkecosystem?somethig=1',
    'https://gitlab.com/arkecosystem/',
    'https://gitlab.com/ArkEcosystem/marketsquare.io',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('gitlab_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/arkecosystem',
    'arkecosystem',
    '/arkecosystem',
    'ftp://www.gitlab.com/something',
    'www.gitlab.com/arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.gitlab_url'));
});
