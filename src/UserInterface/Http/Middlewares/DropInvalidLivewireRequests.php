<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Livewire\Mechanisms\HandleRequests\HandleRequests;

final class DropInvalidLivewireRequests
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->routeIs('livewire.*')) {
            return $next($request);
        }

        if ($this->hasValidSignature($request)) {
            return $next($request);
        }

        if (! app(HandleRequests::class)->isLivewireRequest()) {
            abort(403);
        }

        if (! $this->containsValidPayload($request)) {
            abort(403);
        }

        return $next($request);
    }

    /**
     * The file upload request on Livewire doesn't contain `fingerprint` or
     * `serverMemo` but a signed URL instead that we can validate using the
     * built-in `hasValidSignature` method.
     * (`/livewire/upload-file?expires={timestamp}&signature={signature}`).
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function hasValidSignature(Request $request) : bool
    {
        if ($request->filled('signature')) {
            return $request->hasValidSignature();
        }

        return false;
    }

    /**
     * A valid Livewire request should contain fingerprint data (ID, method) and stuff like checksum.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function containsValidPayload(Request $request) : bool
    {
        return $request->filled(['components.0.calls', 'components.0.snapshot', '_token']);
    }
}
