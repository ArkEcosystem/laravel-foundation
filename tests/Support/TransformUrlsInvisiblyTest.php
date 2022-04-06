<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Support\TransformDotsInUrlsInvisibly;

it('will not change the value when no url is detected', function () {
    $value    = 'This is a normal string.';
    $newValue = (new TransformDotsInUrlsInvisibly($value))->getString();

    expect($newValue)->toBe($value);
});

it('will change the url when a url is detected', function () {
    $value    = 'Your invitation for test.com has been created.';
    $newValue = (new TransformDotsInUrlsInvisibly($value))->getString();

    expect($newValue)->toBe('Your invitation for test<span style="display: none;">.</span>.com has been created.');
});

it('will change two urls when a url is detected', function ($value, $expectation) {
    $newValue = (new TransformDotsInUrlsInvisibly("Your invitation for {$value} has been created."))->getString();

    expect($newValue)->toBe("Your invitation for {$expectation} has been created.");
})->with([
    ['foo.com', 'foo<span style="display: none;">.</span>.com'],
    ['https://foo.com', 'https://foo<span style="display: none;">.</span>.com'],
    ['test.com and test2.com', 'test<span style="display: none;">.</span>.com and test2<span style="display: none;">.</span>.com'],
    ['foo123bar.com', 'foo123bar<span style="display: none;">.</span>.com'],
    ['foo.bar.com', 'foo<span style="display: none;">.</span>.bar<span style="display: none;">.</span>.com'],
    ['foo-bar.foobar.com', 'foo-bar<span style="display: none;">.</span>.foobar<span style="display: none;">.</span>.com'],
    ['foobar.com/test', 'foobar<span style="display: none;">.</span>.com/test'],
    ['foobar.com/test/', 'foobar<span style="display: none;">.</span>.com/test/'],
    ['foobar.com/test?foo=bar&bar=foo', 'foobar<span style="display: none;">.</span>.com/test?foo=bar&bar=foo'],
    ['foobar.com/foo@barbar[foo=bar]', 'foobar<span style="display: none;">.</span>.com/foo@barbar[foo=bar]'],
]);
