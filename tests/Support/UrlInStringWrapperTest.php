<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Support\UrlInStringWrapper;

it('will not change the value when no url is detected', function () {
    $value = 'This is a normal string.';
    $newValue = (new UrlInStringWrapper($value))->getString();

    expect($newValue)->toBe($value);
});

it('will wrap the url in a blank a tag when a url is detected', function () {
    $value = 'Your invitation for test.com has been created.';
    $newValue = (new UrlInStringWrapper($value))->getString();

    expect($newValue)->toBe('Your invitation for <a>test.com</a> has been created.');
});

it('will wrap two urls in a blank a tag when a url is detected', function ($value, $expectation) {
    $newValue = (new UrlInStringWrapper("Your invitation for {$value} has been created."))->getString();

    expect($newValue)->toBe("Your invitation for {$expectation} has been created.");
})->with([
    ['foo.com', '<a>foo.com</a>'],
    ['https://foo.com', '<a>https://foo.com</a>'],
    ['test.com and test2.com', '<a>test.com</a> and <a>test2.com</a>'],
    ['foo123bar.com', '<a>foo123bar.com</a>'],
    ['foo.bar.com', '<a>foo.bar.com</a>'],
    ['foo-bar.foobar.com', '<a>foo-bar.foobar.com</a>'],
    ['foobar.com/test', '<a>foobar.com/test</a>'],
    ['foobar.com/test/', '<a>foobar.com/test/</a>'],
    ['foobar.com/test?foo=bar&bar=foo', '<a>foobar.com/test?foo=bar&bar=foo</a>'],
    ['foobar.com/foo@barbar[foo=bar]', '<a>foobar.com/foo@barbar[foo=bar]</a>'],
]);

it('will add optional attributes', function () {
    $value = 'Your invitation for test.com has been created.';

    $wrapper = new UrlInStringWrapper($value);
    $wrapper->setAttributes(['class' => 'text-black', 'style' => 'color: #000000']);

    expect($wrapper->getString())
        ->toBe('Your invitation for <a class="text-black" style="color: #000000">test.com</a> has been created.');
});
