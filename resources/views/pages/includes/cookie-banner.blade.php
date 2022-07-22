@props([
    'domain',
    'disableOutsideClick' => false,
    'overlayCrossButton'  => false,
    'contactUrl'          => '/contact',
])

@php
    $initMethods = [];
    if ($disableOutsideClick) {
        $initMethods[] = 'disableOutsideClick()';
    }
    if ($disableOutsideClick) {
        $initMethods[] = 'overlayCrossButton()';
    }
    if (config('tracking.analytics.key')) {
        $initMethods[] = sprintf("withtrackingAnalytics('%s', '%s')", config('tracking.analytics.key'), config('tracking.analytics.domain'));
    }
    $initMethods[] = sprintf("init({ appName: '%s', domain: '%s', contactUrl: '%s' })", config("app.name"), $domain, $contactUrl);
@endphp

<script src="{{ mix('js/cookie-consent.js') }}"></script>
<script>
    window.addEventListener('load', () => CookieBanner.{!! implode('.', $initMethods) !!});
</script>
