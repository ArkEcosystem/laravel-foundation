<?php

declare(strict_types=1);

use function Tests\createAttributes;
use Illuminate\Support\Facades\Route;

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
