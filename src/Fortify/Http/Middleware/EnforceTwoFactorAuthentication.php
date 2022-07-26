<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class EnforceTwoFactorAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param Request     $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (config('web.2fa_enabled') === false) {
            return $next($request);
        }

        if ($user === null) {
            return $next($request);
        }

        if ($user->two_factor_secret) {
            return $next($request);
        }

        return redirect()->route('kiosk');
    }
}
