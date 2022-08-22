<?php

declare(strict_types=1);

use function Tests\createAttributes;
use Tests\UserInterface\Mocks\MediaMock;

it('should render the component', function (): void {
    $this
        ->view('ark::navbar.profile', createAttributes([
            'profilePhoto'     => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'      => [],
        ]))
        ->assertSeeHtml('src="https://imgur.com/abc123"');
});

it('should render the [profileMenuClass] attribute', function (): void {
    $this
        ->view('ark::navbar.profile', createAttributes([
            'profilePhoto'     => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'      => [],
            'profileMenuClass' => 'unicorn',
        ]))
        ->assertSeeHtml('src="https://imgur.com/abc123"')
        ->assertSeeHtml('unicorn');
});

it('should render the [identifier] attribute instead of the [profilePhoto] attribute', function (): void {
    $this
        ->view('ark::navbar.profile', createAttributes([
            'profilePhoto' => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'  => [],
            'identifier'   => 'unicorn',
        ]))
        ->assertSeeHtml('avatar-wrapper');
});
