<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('facebook');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('facebook_url', $url));
})->with([
    'http://www.facebook.com/arkecosystem',
    'http://facebook.com/arkecosystem',
    'https://www.facebook.com/arkecosystem',
    'https://facebook.com/arkecosystem',
    'http://www.facebook.com/#!/arkecosystem',
    'http://www.facebook.com/pages/Ark-Eco/Ark/123456?v=app_5',
    'http://www.facebook.com/pages/Ark/456',
    'http://www.facebook.com/#!/page_with_1_number',
    'http://www.facebook.com/bounce_page#!/pages/Ark/456',
    'http://www.facebook.com/bounce_page#!/arkecosystem?v=app_166292090072334',
    'https://www.facebook.com/100004123456789',
    'https://www.facebook.com/profile.php?id=100004123456789',
    'https://www.fb.me/profile.php?id=100004123456789',
    'http://www.fb.me/profile.php?id=100004123456789',
    'https://fb.me/profile.php?id=100004123456789',
    'http://fb.me/profile.php?id=100004123456789',
    'https://www.facebook.com/groups/arkecosystem',
    'https://facebook.com/groups/arkecosystem',
    'http://www.facebook.com/groups/arkecosystem',
    'http://facebook.com/groups/arkecosystem',
    'https://fb.me/groups/arkecosystem',
    'https://www.fb.me/groups/arkecosystem',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('facebook_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/arkecosystem',
    'arkecosystem',
    '/arkecosystem',
    'ftp://www.facebook.com/pages/Ark-Eco/Ark/123456?v=app_5',
    'http://www.tacebook.com/bounce_page',
    'https://www.facebook.com/',
    'http://www.facebook.com/',
    'https://facebook.com/',
    'http://facebook.com/',
    'https://fb.me/',
    'https://www.fb.me/',
    'http://www.fb.me/',
    'http://fb.me/',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.custom.facebook_url'));
});
