<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('linkedin');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('linkedin_url', $url));
})->with([
    'http://linkedin.com/in/arkecosystem',
    'https://linkedin.com/in/arkecosystem',
    'http://www.linkedin.com/in/arkecosystem',
    'https://www.linkedin.com/in/arkecosystem',
    'https://www.linkedin.com/in/sam-harper-pittam-64578b177/',
    'https://www.linkedin.com/company/linkedin/',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('linkedin_url', $url))->toBeFalse();
})->with([
    'ftp://linkedin.com/in/arkecosystem',
    'http://twitter.com/in/arkecosystem',
    'http://linkedin.com/arkecosystem',
    'linkedin.com/arkecosystem',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.custom.linkedin_url'));
});
