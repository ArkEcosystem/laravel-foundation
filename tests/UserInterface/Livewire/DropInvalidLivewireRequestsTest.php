<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Http\Middlewares\DropInvalidLivewireRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\Livewire;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\UserInterface\Livewire\DummyComponent;

function mockRequest(string $routeName = 'testing::dummy', array $payload = []) : Request
{
    $route = Route::get('/dummy', fn () => response('OK'))->name($routeName);

    $request = tap(new Request())
            ->setRouteResolver(fn () => $route)
            ->merge($payload);

    $request->headers->set('X-Livewire', '');

    return $request;
}

it('ignores all non-livewire requests', function () {
    $request = mockRequest();

    expect($request->routeIs('testing::dummy'))->toBeTrue();

    $called = false;

    $response   = (new DropInvalidLivewireRequests())->handle($request, function () use (&$called) {
        $called = true;

        return 'Hello world';
    });

    expect($response)->toBe('Hello world');
    expect($called)->toBeTrue();
});

it('drops if snapshot is missing', function () {
    $request = mockRequest('livewire.message', [
        'components' => [
            [
                'updates'  => [],
                'calls'    => [
                    [
                        'path'   => 'invalid-route-path',
                        'method' => '__dispatch',
                        'params' => ['themeChanged', ['newValue' => 'dark']],
                    ],
                ],
            ],
        ],
        '_token' => '123',
    ]);

    $this->app->instance('request', $request);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if calls is missing', function () {
    $request = mockRequest('livewire.message', [
        'components' => [
            [
                'updates'  => [],
            ],
        ],
        '_token' => '123',
    ]);

    $this->app->instance('request', $request);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if token is missing', function () {
    $request = mockRequest('livewire.message', [
        'components' => [
            [
                'snapshot' => '{"data":{"options":[[[{"icon":"sun","value":"light"},{"s":"arr"}],[{"icon":"moon","value":"dark"},{"s":"arr"}],[{"icon":"moon-stars","value":"dim"},{"s":"arr"}]],{"s":"arr"}],"setting":"theme","currentValue":"dark"},"memo":{"id":"x379QXjQDbJVacXZUrKA","name":"navbar.mobile-dark-mode-toggle","path":"delegates","method":"GET","children":[],"scripts":[],"assets":[],"errors":[],"locale":"en"},"checksum":"d0d8b6bf20ba442262d305eff05183949e6510c7be8a0ad11311fa92db4a5739"}',
                'updates'  => [],
                'calls'    => [
                    [
                        'path'   => 'invalid-route-path',
                        'method' => '__dispatch',
                        'params' => ['themeChanged', ['newValue' => 'dark']],
                    ],
                ],
            ],
        ],
    ]);

    $this->app->instance('request', $request);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if payload is missing', function () {
    $request = mockRequest('livewire.message', [
        //
    ]);

    $this->app->instance('request', $request);

    try {
        (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('lets request through if all of the methods are valid', function () {
    $this->withHeaders(['X-Livewire' => '']);

    $request = mockRequest('livewire.message', [
        'components' => [
            [
                'snapshot' => '{"data":{"options":[[[{"icon":"sun","value":"light"},{"s":"arr"}],[{"icon":"moon","value":"dark"},{"s":"arr"}],[{"icon":"moon-stars","value":"dim"},{"s":"arr"}]],{"s":"arr"}],"setting":"theme","currentValue":"dark"},"memo":{"id":"x379QXjQDbJVacXZUrKA","name":"navbar.mobile-dark-mode-toggle","path":"delegates","method":"GET","children":[],"scripts":[],"assets":[],"errors":[],"locale":"en"},"checksum":"d0d8b6bf20ba442262d305eff05183949e6510c7be8a0ad11311fa92db4a5739"}',
                'updates'  => [],
                'calls'    => [
                    [
                        'path'   => 'invalid-route-path',
                        'method' => '__dispatch',
                        'params' => ['themeChanged', ['newValue' => 'dark']],
                    ],
                ],
            ],
        ],
        '_token' => '123',
    ]);

    $this->app->instance('request', $request);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        expect(true)->toBeTrue();
    } catch (HttpException $e) {
        $this->fail('HTTPException was thrown, even though it should not be');
    }
});
