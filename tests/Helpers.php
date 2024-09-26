<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Foundation\Blog\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Illuminate\View\ComponentAttributeBag;

function createAttributes(array $attributes): array
{
    $defaults = [
        'name'   => 'username',
        'errors' => new ViewErrorBag(),
    ];

    return array_merge([
        'attributes' => new ComponentAttributeBag(array_merge($defaults, $attributes)),
    ], $defaults, $attributes);
}

function createViewAttributes(array $attributes): array
{
    return array_merge([
        'attributes' => new ComponentAttributeBag($attributes),
    ], $attributes);
}

function createUserModel(string $userClass = User::class)
{
    return $userClass::create([
        'name'              => 'John Doe',
        'username'          => 'john.doe',
        'email'             => 'john@doe.com',
        'email_verified_at' => Carbon::now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'timezone'          => 'UTC',
    ]);
}

function createBrowserSessionForUser(string $ip, User $user, int $unixTime): string
{
    $random_id = Str::random(10);
    DB::table('sessions')->insert([
        'id'            => $random_id,
        'user_id'       => $user->id,
        'ip_address'    => $ip,
        'user_agent'    => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.1 Safari/605.1.15',
        'payload'       => Str::random(10),
        'last_activity' => $unixTime,
    ]);

    return $random_id;
}

function expectValidationError(Closure $callback, string $key, string $reason): void
{
    try {
        $callback();

        test()->fail('No expected validation errors have been thrown.');
    } catch (ValidationException $exception) {
        expect($exception->validator->errors()->has($key))->toBeTrue();
        expect($exception->validator->errors()->get($key))->toContain($reason);
    }
}
