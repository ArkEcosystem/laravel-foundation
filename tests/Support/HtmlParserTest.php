<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Support\HtmlParser;
use Illuminate\Support\Collection;

it('can find all links in an html', function () {
    $parser = new HtmlParser('
        <a href="/hello-world">Hello World</a>
        <a href="#contact">Contact</a>
        <a href="https://google.com">Google</a>
        <p>Dummy paragraphy</p>
        <a href="/about-us">About Us</a>
        <a>Should Be Removed Because No Link</a>
        <a href="/should-be-trimmed ">Should Be Trimmed</a>
    ');

    $links = $parser->links();

    expect($links)->toBeInstanceOf(Collection::class);
    expect($links)->toHaveCount(5);

    expect($links[0])->toBe('/hello-world');
    expect($links[1])->toBe('#contact');
    expect($links[2])->toBe('https://google.com');
    expect($links[3])->toBe('/about-us');
    expect($links[4])->toBe('/should-be-trimmed');
});
