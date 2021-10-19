<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('website');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('website_url', $url));
})->with([
    'https://www.protokol.com.br',
    'https://protokol.mx',
    'https://www.protokol.com/',
    'https://ark.io/',
    'http://ark.io',
    'http://www.ark.io',
    'http://www.ark.io',
    'https://www.google.com/search?q=url+validation&oq=url+validation&aqs=chrome..69i57.2073j0j1&sourceid=chrome&ie=UTF-8',
    'http://hello-world.com',
    'http://hello-world.com/something/test/#hello',
    'https://127.0.0.1',
    'http://www.regexbuddy.com/index.html?source=library',
    'http://mail.google.com',
    // Unstoppabledomains
    'http://hello-world.x',
    'http://hello-world.888',
    'http://hello-world.dao',
    'http://hello-world.crypto',
    'http://hello-world.coin',
    'http://hello-world.wallet',
    'http://hello-world.bitcoin',
    'http://hello-world.nft',
    'http://hello-world.zil',
    'http://hello-world.blockchain',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('website_url', $url))->toBeFalse();
})->with([
    'ftp://www.google.com',
    '127.0.0.1',
    'https://a=a',
    'http://bob.',
    'http://🙊.com',
    'http://hello-.123',
    'http://*.com',
    'http://asfas!.com',
    'http://hello_world.com',
    'http://hello~world.com',
    'http://-helloworld.com',
    'http://helloworld-.com',
    'https://www.mp3#.com',
    'ark.io',
    'www.protokol.com',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.custom.website_url'));
});
