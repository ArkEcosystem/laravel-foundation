<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\RegEx;

it('can create a regex', function ($name) {
    expect(RegEx::socialMediaLink($name))->toBestring();
})->with([
    'discord',
    'facebook',
    'instagram',
    'linkedin',
    'marketsquare',
    'telegram',
    'twitter',
]);

it('fails to create a regex url for an invalid service for social media link', fn () => RegEx::socialMediaLink('invalid'))->throws(Exception::class);
it('fails to create a regex url for an invalid service for social media name', fn () => RegEx::socialMediaName('invalid'))->throws(Exception::class);

it('can validate a youtube url as correct video source', function () {
    expect(RegEx::videoSource('youtube', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'https://youtube.com/watch?v=dQw4w9WgXcQ'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'http://www.youtube.com/watch?v=dQw4w9WgXcQ'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'http://youtube.com/watch?v=dQw4w9WgXcQ'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'http://youtu.be/FdeioVndUhs'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'https://youtu.be/FdeioVndUhs'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'https://www.youtu.be/FdeioVndUhs'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'http://www.youtu.be/FdeioVndUhs'))->toBeTrue();
    expect(RegEx::videoSource('youtube', 'https://www.youtube.com/embed/dQw4w9WgXcQ'))->toBeTrue();
});

it('cannot validate an invalid url as correct video source', function () {
    expect(RegEx::videoSource('youtube', 'https://www.yootube.com/watch?v=dQw4w9WgXcQ'))->toBeFalse();
});

it('should return false if the provided video source is invalid', function () {
    expect(RegEx::videoSource('invalid', 'https://youtube.com/'))->toBeFalse();
});

it('extracts the twitter username from a twitter url', function ($url) {
    expect(RegEx::getTwitterUsername($url))->toBe('arkecosystem');
})->with([
    'https://twitter.com/arkecosystem',
    'https://twitter.com/arkecosystem/',
    'https://twitter.com/arkecosystem/?test=test&foo=bar',
    'https://twitter.com/arkecosystem?test=test&foo=bar',
]);

it('extracts the domain from a given url', function ($domain, $url) {
    $host = parse_url($url, PHP_URL_HOST);

    expect(RegEx::getDomainFromHost($host))->toBe($domain);
})->with([
    ['marketsquare.io', 'http://marketsquare.io/sub/?foo=bar'],
    ['marketsquare.io', 'http://marketsquare.io'],
    ['marketsquare.io', 'https://marketsquare.io'],
    ['marketsquare.io', 'https://www.marketsquare.io'],
    ['marketsquare.io', 'http://www.marketsquare.io'],
    ['marketsquare.com.fr', 'http://www.marketsquare.com.fr?'],
    ['marketsquare.com.fr', 'http://marketsquare.com.fr/'],
    ['users.marketsquare.com.fr', 'http://users.marketsquare.com.fr/'],
    ['u.marketsquare.com.fr', 'http://u.marketsquare.com.fr/'],
    ['ark.io', 'https://ark.io'],
    ['ark.io', 'https://www.ark.io'],
    ['learn.ark.io', 'https://learn.ark.io'],
    ['www.com', 'https://www.www.com'],
]);
