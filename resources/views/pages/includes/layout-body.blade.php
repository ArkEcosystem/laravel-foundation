@props([
    'includes'     => null,
    'footer'       => null,
    'cookieDomain' => null,
])

<body {{ $attributes }}>
    <div
        id="app"
        @class([
            'flex flex-col antialiased bg-white',
            'dark:bg-theme-secondary-900' => config('ui.dark-mode.enabled') === true,
        ])
    >
        {{ $slot }}
    </div>

    @if ($footer)
        {{ $footer }}
    @else
        <x-ark-footer />
    @endif

    @livewireScripts

    {{ $includes }}

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    @if (Visitor::isEuropean())
        <x-ark-pages-includes-cookie-banner :domain="$cookieDomain" />
    @elseif (config('tracking.analytics.key'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('tracking.analytics.key') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ config('tracking.analytics.key') }}');
        </script>
    @endif
</body>
