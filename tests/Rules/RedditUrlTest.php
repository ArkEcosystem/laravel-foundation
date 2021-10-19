<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('reddit');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('reddit_url', $url));
})->with([
    'https://old.reddit.com/user/ark',
    'https://reddit.com/u/ark',
    'https://www.reddit.com/r/Ripple',
    'https://www.reddit.com/user/nvok/',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('reddit_url', $url))->toBeFalse();
})->with([
    'http://reddit.com/arkecosystem',
    'www.reddit.com/arkecosystem',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.reddit_url'));
});
