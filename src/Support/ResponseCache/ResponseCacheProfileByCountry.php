<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Support\ResponseCache;

use ARKEcosystem\Foundation\Support\Facades\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

final class ResponseCacheProfileByCountry extends CacheAllSuccessfulGetRequests
{
    public function useCacheNameSuffix(Request $request): string
    {
        if (Auth::check()) {
            return (string) Auth::id();
        }

        return Visitor::isEuropean() ? 'european' : 'non-european';
    }
}
