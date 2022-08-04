<?php

declare(strict_types=1);

use function Tests\createAttributes;
use Illuminate\Support\Facades\Route;

it('should render the component with a single item without query parameters', function (): void {
    Route::view('/', 'ark::navbar.items.desktop')->name('home');

    $this
        ->view('ark::navbar.items.desktop', createAttributes([
            'navigation' => [
                ['route' => 'home', 'label' => 'Home'],
            ],
        ]))
        ->assertSeeHtml('http://localhost');
});

it('should render the component with a single item with query parameters', function (): void {
    Route::view('/', 'ark::navbar.items.desktop')->name('home');

    $this
        ->view('ark::navbar.items.desktop', createAttributes([
            'navigation' => [
                ['route' => 'home', 'label' => 'Home', 'params' => ['hello' => 'world']],
            ],
        ]))
        ->assertSeeHtml('http://localhost?hello=world');
});

it('should render the component with children', function (): void {
    Route::view('/', 'ark::navbar.items.desktop')->name('home');
    Route::view('/post', 'ark::navbar.items.desktop')->name('post');

    $this
        ->view('ark::navbar.items.desktop', createAttributes([
            'navigation' => [
                [
                    'route'    => 'home',
                    'label'    => 'Home',
                    'children' => [
                        ['route' => 'post', 'label' => 'Post'],
                    ],
                ],
            ],
        ]))
        ->assertSeeHtml('http://localhost/post');
});
