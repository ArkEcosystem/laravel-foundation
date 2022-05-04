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

    return tap(new Request())
            ->setRouteResolver(fn () => $route)
            ->merge($payload);
}

it('ignores all non-livewire requests', function () {
    $request = mockRequest();

    expect($request->routeIs('testing::dummy'))->toBeTrue();

    $called = false;

    $response = (new DropInvalidLivewireRequests())->handle($request, function () use (&$called) {
        $called = true;

        return 'Hello world';
    });

    expect($response)->toBe('Hello world');
    expect($called)->toBeTrue();
});

it('drops if component is not found', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andThrow(ComponentNotFoundException::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint ID is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => '',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint component name is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => '',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint method is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => '',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint path is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if checksum is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => '',
            'htmlHash' => 'some-hash',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if html hash is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => '',
        ],
    ]);

    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn('done');

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

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

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fired events do not exist', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
        'updates' => [
            [
                'payload' => [],
                'type'    => 'somethingRandom',
            ],
            [
                'payload' => [
                    'event'  => 'dummy',
                    'id'     => 'dummy-event-id',
                    'params' => 'test',
                ],
                'type' => 'fireEvent',
            ],
            [
                'payload' => [
                    'event'  => 'something-invalid',
                    'id'     => 'dummy-event-id-2',
                    'params' => 'test',
                ],
                'type' => 'fireEvent',
            ],
        ],
    ]);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if payload contains any fired event with an empty name', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
        'updates' => [
            [
                'payload' => [],
                'type'    => 'somethingRandom',
            ],
            [
                'payload' => [
                    'event'  => 'dummy',
                    'id'     => 'dummy-event-id',
                    'params' => 'test',
                ],
                'type' => 'fireEvent',
            ],
            [
                'payload' => [
                    'event'  => '',
                    'id'     => 'dummy-event-id-2',
                    'params' => 'test',
                ],
                'type' => 'fireEvent',
            ],
        ],
    ]);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('lets through requests if events are valid', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
        'updates' => [
            [
                'payload' => [],
                'type'    => 'somethingRandom',
            ],
            [
                'payload' => [
                    'event'  => 'dummy',
                    'id'     => 'dummy-event-id',
                    'params' => 'test',
                ],
                'type' => 'fireEvent',
            ],
        ],
    ]);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        expect(true)->toBeTrue();
    } catch (HttpException $e) {
        $this->fail('HTTPException was thrown, even though it shouldn not be.');
    }
});

it('lets through requests if any of the valid events are not specified', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
        'updates' => [
            [
                'payload' => [],
                'type'    => 'somethingRandom',
            ],
            [
                'payload' => [
                    'event'  => 'anotherDummy',
                    'id'     => 'dummy-event-id',
                    'params' => 'test',
                ],
                'type' => 'fireEvent',
            ],
        ],
    ]);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        expect(true)->toBeTrue();
    } catch (HttpException $e) {
        $this->fail('HTTPException was thrown, even though it shouldn not be.');
    }
});

it('drops if payload contains any callable methods that do not exist', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
        'updates' => [
            [
                'payload' => [],
                'type'    => 'somethingRandom',
            ],
            [
                'payload' => [
                    'method'  => 'doSomething',
                    'id'      => 'dummy-method-id',
                    'params'  => 'test',
                ],
                'type' => 'callMethod',
            ],
            [
                'payload' => [
                    'method'  => 'somethingInvalid',
                    'id'      => 'dummy-method-id-2',
                    'params'  => 'test',
                ],
                'type' => 'callMethod',
            ],
        ],
    ]);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('lets request through if all of the methods are valid', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id'     => 'dummy-id',
            'name'   => 'dummy-name',
            'method' => 'POST',
            'path'   => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
        'updates' => [
            [
                'payload' => [],
                'type'    => 'somethingRandom',
            ],
            [
                'payload' => [
                    'method'  => 'doSomething',
                    'id'      => 'dummy-method-id',
                    'params'  => 'test',
                ],
                'type' => 'callMethod',
            ],
            [
                'payload' => [
                    'method'  => '$set',
                    'id'      => 'dummy-method-id-2',
                    'params'  => 'test',
                ],
                'type' => 'callMethod',
            ],
        ],
    ]);

    Livewire::partialMock();

    Livewire::shouldReceive('getInstance')->andReturn(new DummyComponent('dummy-id'));
    Livewire::shouldReceive('getClass')->with('dummy-name')->andReturn(DummyComponent::class);

    try {
        $response = (new DropInvalidLivewireRequests())->handle($request, fn () => 'Hello world');

        expect(true)->toBeTrue();
    } catch (HttpException $e) {
        $this->fail('HTTPException was thrown, even though it shouldn not be.');
    }
});
