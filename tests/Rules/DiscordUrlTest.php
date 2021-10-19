<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('discord');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('twitter_url', $url));
})->with([
    'https://discord.gg/ipod',
    'https://discord.gg/invite/ipod',
    'https://www.discord.gg/ipod',
    'https://discord.gg/ipod',
    'https://discord.gg/invite/ipod',
    'https://www.discord.gg/ipod',
    'https://discord.com/invite/VNRfxwQ',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('discord_url', $url))->toBeFalse();
})->with([
    'http://twitter.gg/ipod',
    'cryptoarkproject.slack.com',
    'discord.gg/ipod',
    '@arkecosystem',
    'arkecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.discord_url'));
});
