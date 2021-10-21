<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\UI;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

it('should return boot error messages', function ($errorCode): void {
    expect(UI::getErrorMessage($errorCode))->toBe(trans('ui::errors.'.$errorCode));
})->with([
    401,
    403,
    404,
    419,
    429,
    500,
    503,
]);

it('should update error messages', function ($errorCode): void {
    expect(UI::getErrorMessage($errorCode))->toBe(trans('ui::errors.'.$errorCode));

    UI::useErrorMessage($errorCode, 'testing '.$errorCode);

    expect(UI::getErrorMessage($errorCode))->toBe('testing '.$errorCode);
})->with([
    401,
    403,
    404,
    419,
    429,
    500,
    503,
]);

it('should handle various request query types with paginator', function ($requestPath, $expectation = []): void {
    $paginator = new LengthAwarePaginator([], 500, 10, 1, ['pageName' => 'page']);

    $this->app->instance('request', Request::create($requestPath));

    $data = UI::getPaginationData($paginator);

    expect($data['pageName'])->toBe('page');
    expect($data['urlParams']->toArray())->toBe($expectation);
})->with([
    ['/blog?12345=', [
        '12345' => '',
    ]],
    ['/blog?12345=test', [
        '12345' => 'test',
    ]],
    ['/blog?test=12345', [
        'test' => '12345',
    ]],
    '/blog?page=12345',
    ['/blog?pageName=12345', [
        'pageName' => '12345',
    ]],
    '/blog?',
    '/blog',
]);
