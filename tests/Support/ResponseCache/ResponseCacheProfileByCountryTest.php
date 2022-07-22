<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Support\ResponseCache\ResponseCacheProfileByCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

it('has a suffix for guest user if comes from europe ', function () {
    $suffix = (new ResponseCacheProfileByCountry())->useCacheNameSuffix(new Request());

    expect($suffix)->toBe('european');
});

it('has a suffix for guest user if doesnt not come from europe ', function () {
    $request = new Request();

    $request->headers->replace(['cf-ipcountry' => 'MX']);

    app()->instance('request', $request);

    $suffix = (new ResponseCacheProfileByCountry())->useCacheNameSuffix(new Request());

    expect($suffix)->toBe('non-european');
});

it('has a suffix for auth user', function () {
    Auth::shouldReceive('check')
        ->andReturn(true)
        ->shouldReceive('id')
        ->andReturn('1');

    $suffix = (new ResponseCacheProfileByCountry())->useCacheNameSuffix(new Request());

    expect($suffix)->toBe('1');
});
