<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('weibo');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('weibo_url', $url));
})->with([
    'https://weibo.com/ipod',
    'https://app.weibo.com/something/ipod',
    'https://www.weibo.com/ipod',
    'https://something.weibo.com/ipod',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('weibo_url', $url))->toBeFalse();
})->with([
    'http://twitter.gg/ipod',
    'cryptoarkproject.weibo.com',
    'weibo.com/something',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.weibo_url'));
});
