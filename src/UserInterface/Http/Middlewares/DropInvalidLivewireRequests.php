<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\Livewire;

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

        if (! $this->containsValidPayload($request)) {
            // Throwing 404 Not Found for some reason doesn't work as Livewire doesn't know how to intercept the 404,
            // as it actually expects a response.(I guess as this wasn't working before with 404).
            // If 403 is thrown, Livewire knows to actually throw back 403 to browser.
            abort(403);
        }

        if (! $this->isValidComponent($request->input('fingerprint.name'))) {
            abort(403);
        }

        if ($this->fireableEvents($request)->isNotEmpty()) {
            $this->ensureFireableEventsAreValid($request);
        }

        $this->ensureCallableMethodsExist($request);

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
     * We want to drop all Livewire requests that want to manipulate on a component that doesn't even exist.
     *
     * @param string $component
     *
     * @return bool
     */
    private function isValidComponent(string $component) : bool
    {
        try {
            return Livewire::getClass($component) !== null;
        } catch (ComponentNotFoundException $e) {
            return false;
        }
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
        return $request->filled(['fingerprint.id', 'fingerprint.method', 'fingerprint.name', 'fingerprint.path'])
            && $request->filled(['serverMemo.checksum', 'serverMemo.htmlHash']);
    }

    /**
     * Ensure all events that the request fires actually exist for the Livewire component.
     * If there are some events that want to be fired and they don't exist on the component,
     * we want to respond with 403.
     *
     * @param Request $request
     * @return void
     */
    private function ensureFireableEventsAreValid(Request $request) : void
    {
        $component = $this->resolveComponentInstance($request);

        abort_if($this->fireableEvents($request)->diff(
            $component->getEventsBeingListenedFor()
        )->isNotEmpty(), 403);
    }

    /**
     * Get all of the events that the request wants to fire for the Livewire component.
     *
     * @param Request $request
     * @return Collection
     */
    private function fireableEvents(Request $request) : Collection
    {
        return $request->collect('updates')
                    ->filter(fn (array $update) => ($update['type'] ?? '') === 'fireEvent')
                    ->pluck('payload.event')
                    ->unique()
                    ->values();
    }

    /**
     * Ensure all methods that the request wants to call actually exist for the Livewire component.
     * Since Livewire interally uses `method_exist`, we can leverage that.
     *
     * @param Request $request
     * @return void
     */
    private function ensureCallableMethodsExist(Request $request) : void
    {
        $component = $this->resolveComponentInstance($request);

        $request->collect('updates')
                    ->filter(fn (array $update) => ($update['type'] ?? '') === 'callMethod')
                    ->pluck('payload.method')
                    ->reject(fn ($method) => $this->isMagicMethod($method))
                    ->unique()
                    ->values()
                    ->each(function ($method) use ($component) {
                        abort_unless(method_exists($component, $method), 403);
                    });
    }

    /**
     * Determine whether the method is a Livewire's internal magic method.
     *
     * @param string $method
     * @return bool
     */
    private function isMagicMethod(string $method) : bool
    {
        return in_array($method, [
            '$sync',
            '$set',
            '$toggle',
            '$refresh',
        ], true);
    }

    /**
     * Resolve the component instance from the Request.
     *
     * @param Request $request
     * @return Component
     */
    private function resolveComponentInstance(Request $request) : Component
    {
        try {
            return Livewire::getInstance(
                $request->input('fingerprint.name'),
                $request->input('fingerprint.id')
            );
        } catch (ComponentNotFoundException $e) {
            abort(403);
        };
    }
}
