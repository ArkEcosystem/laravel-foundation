<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('medium');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('medium_url', $url));
})->with([
    'https://medium.com/@karllorey',
    'http://medium.com/@karllorey',
    'http://www.medium.com/@karllorey',
    'https://medium.com/get-protocol',
    'https://medium.com/u/b3d3d3653c2c?source=post_page-----da92b81b85ef----------------------',
    'https://karllorey.medium.com/?b3d3d3653c2c?source=post_page-----da92b81b85ef----------------------',
    'https://some-user-1.medium.com',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('medium_url', $url))->toBeFalse();
})->with([
    'ftp://www.medium.com/@karllorey',
    'www.medium.com/@karllorey',
    '@arkecosystem',
    'arkecosystem',
    'https://@user.medium.com',
    'https://lower_case.medium.com',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.medium_url'));
});
