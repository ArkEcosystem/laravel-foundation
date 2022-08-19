<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use function Tests\createAttributes;

it('should render the component', function (): void {
    Route::view('/', 'ark::navbar.logo')->name('home');

    $this
        ->view('ark::navbar.logo', createAttributes([
            'title' => 'Explorer',
        ]))
        ->assertSeeHtml('<div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> Explorer</div>');
});

it('should render the [logo] slot', function (): void {
    Route::view('/', 'ark::navbar.logo')->name('home');

    $this
        ->view('ark::navbar.logo', createAttributes([
            'logo' => 'custom-logo',
        ]))
        ->assertSeeHtml('custom-logo');
});
