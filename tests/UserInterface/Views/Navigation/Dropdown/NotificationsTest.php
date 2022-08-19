<?php

declare(strict_types=1);

it('should render the component', function (): void {
    $this
        ->view('ark::navbar.notifications', [
            'notificationsIndicator' => 'indicator',
            'notifications'          => 'list of notifications',
        ])
        ->assertSeeText('list of notifications');
});

it('should render the [dropdownClasses] attribute', function (): void {
    $this
        ->view('ark::navbar.notifications', [
            'notificationsIndicator' => 'indicator',
            'notifications'          => 'list of notifications',
            'dropdownClasses'        => 'unicorn',
        ])
        ->assertSeeText('list of notifications')
        ->assertSeeHtml('unicorn');
});
