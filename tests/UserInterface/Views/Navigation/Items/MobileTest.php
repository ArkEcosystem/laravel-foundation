<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use function Tests\createAttributes;

it('should render the component with a single item without query parameters', function (): void {
    Route::view('/', 'ark::navbar.items.mobile')->name('home');

    $this
        ->view('ark::navbar.items.mobile', createAttributes([
            'navigation' => [
                ['route' => 'home', 'label' => 'Home'],
            ],
        ]))
        ->assertSeeHtml('http://localhost');
});

it('should render the component with a single item with query parameters', function (): void {
    Route::view('/', 'ark::navbar.items.mobile')->name('home');

    $this
        ->view('ark::navbar.items.mobile', createAttributes([
            'navigation' => [
                ['route' => 'home', 'label' => 'Home', 'params' => ['hello' => 'world']],
            ],
        ]))
        ->assertSeeHtml('http://localhost?hello=world');
});
