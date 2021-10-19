<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('youtube');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('youtube_url', $url));
})->with([
    'http://www.youtube.com/channel/uc_fglsfl',
    'http://youtube.co.uk/channel/asdasgfgjd',
    'https://youtube.com/channel/ghjgk+öää,',
    'https://youtube.net/channel/43568&gsldkfj',
    'https://youtube.de/channel/dtgzu&&dadg ',
    'http://youtube.com/channel/vgujsgh&as=gr',
    'http://youtube.com/channel/xdfhxfgu',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('youtube_url', $url))->toBeFalse();
})->with([
    'http://twitter.gg/ipod',
    'youtube.com/channel/ghjg',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.youtube_url'));
});
