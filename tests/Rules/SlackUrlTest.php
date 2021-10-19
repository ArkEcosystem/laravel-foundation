<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('slack');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('slack_url', $url));
})->with([
    'https://cryptoarkproject.slack.com',
    'http://cryptoarkproject.slack.com',
    'https://samco-crew.slack.com',
    'https://samco_crew.slack.com',
    'https://samcocrew1.slack.com',
    'https://SamcoCrew1.slack.com',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('slack_url', $url))->toBeFalse();
})->with([
    'http://www.cryptoarkproject.slack.com',
    'cryptoarkproject.slack.com',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.slack_url'));
});
