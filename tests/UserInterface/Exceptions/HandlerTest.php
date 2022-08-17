<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

it('should show 500 error page if template does not exist', function ($errorCode, $message): void {
    Route::view('home', '')->name('home');
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
    Route::view('home', '')->name('home');
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
