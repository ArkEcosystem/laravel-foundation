<?php

declare(strict_types=1);

use function Tests\createAttributes;

it('should render the component', function (): void {
    $this
        ->view('ark::navbar.hamburger', createAttributes([]))
        ->assertSeeHtml('flex items-center');
});
