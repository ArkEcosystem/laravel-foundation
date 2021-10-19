<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('hive');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('hive_url', $url));
})->with([
    'https://hive.com/ipod',
    'https://app.hive.com/invite/ipod',
    'https://www.hive.com/ipod',
    'https://something.hive.com/ipod',
    'https://hive.blog/@aggroed',
    'https://ecency.com/@hello-msq',
    'https://peakd.com/@hello-msq',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('hive_url', $url))->toBeFalse();
})->with([
    'http://twitter.gg/ipod',
    'cryptoarkproject.hive.com',
    'hive.com/something',
    '@arkecosystem',
    'arkecosystem',
    'ecency.com',
    'ecency.com/@hellomsq',
    'https://ecency.com/',
    'https://ecency.com/msq-123',
    'https://ecency.com/msq-123/@hellomsq',
    'https://ecency.com/msq-123/@hello-msq/welcome-marketsquare',
    'peakd.com',
    'peakd.com/@hellomsq',
    'https://peakd.com/',
    'https://peakd.com/msq-123',
    'https://peakd.com/msq-123/@hellomsq',
    'https://www.peakd.com/msq-123/@hello-msq/welcome-marketsquare',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.hive_url'));
});
