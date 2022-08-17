<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

it('should show 500 error page if template does not exist', function ($errorCode, $message): void {
    Route::view('/home', function () {
        return '';
    })->name('home');
    Route::get('error/{code}', function ($code) {
        abort($code);
    });

    $response = $this->get("/error/${errorCode}")
        ->assertSeeText($message);

    $this->assertStringContainsString('<title>'.trans('ui::errors.500').' | Laravel</title>', $response->getContent());
})->with([
    [402, 'Oops, something went wrong'],
    [408, 'Oops, something went wrong'],
    [501, 'Oops, something went wrong'],
    [519, 'Oops, something went wrong'],
]);

it('should show correct error page', function ($errorCode, $message): void {
    Route::view('/home', function () {
        return '';
    })->name('home');
    Route::get('error/{code}', function ($code) {
        abort($code);
    });

    $response = $this->get("/error/${errorCode}")
        ->assertSeeText($message);

    $this->assertStringContainsString('<title>'.trans("ui::errors.${errorCode}").' | Laravel</title>', $response->getContent());
})->with([
    [401, 'Oops, something went wrong'],
    [403, 'Oops, this is a restricted area!'],
    [404, 'Oops, something went wrong'],
    [419, 'Oops, something went wrong'],
    [429, 'Oops, something went wrong'],
    [500, 'Oops, something went wrong'],
    [503, 'Laravel is currently down for scheduled maintenance.'],
]);

it('should use contact route for button if route exists', function ($useRoute): void {
    Route::view('home', function () {
        return '';
    })->name('home');
    Route::get('error/{code}', function ($code) {
        abort($code);
    });

    Config::set('mail.contact_email', 'test@ark.io');

    if ($useRoute) {
        Route::get('/contact', function () {
            return '';
        })->name('contact');
    }

    $response = $this->get('/error/404');

    if ($useRoute) {
        $response->assertSeeInOrder([
            'Oops, something went wrong',
            route('contact'),
            'Contact',
        ]);
    } else {
        $response->assertSeeInOrder([
            'Oops, something went wrong',
            'test@ark.io',
            'Contact',
        ]);
    }
})->with([
    true,
    false,
]);
