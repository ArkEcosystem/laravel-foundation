@props([
    'includes'                  => null,
    'footer'                    => null,
    'content'                   => null,
    'cookieDomain'              => null,
    'wrapperClass'              => 'bg-white',
    'disableCookieOutsideClick' => false,
    'overlayCookieCrossButton'  => false,
    'cookieContactUrl'          => '/contact',
    'inertia' => false,
])

@aware([
    'verticalCenterContent' => false,
])

<body {{ $attributes }}>
    <div
        id="app"
        @class([
            'flex flex-col antialiased',
            $wrapperClass,
            'dark:bg-theme-secondary-900' => config('ui.dark-mode.enabled') === true,
        ])
    >
        {{ $slot }}

        @if ($content === null)
            <x-ark-pages-includes-layout-content :vertical-center="$verticalCenterContent">
                @yield('content')
            </x-ark-pages-includes-layout-content>
        @else
            {{ $content }}
        @endif
    </div>

    @if ($footer)
        {{ $footer }}
    @else
        <x-ark-footer />
    @endif

    @if (! $inertia)
        @livewireScriptConfig

        @livewire('toast')
    @endif

    {{ $includes }}

    @stack('extraStyle')

    @stack('footer')

    <!-- Scripts -->
    @vite('resources/js/app.js')

    @if (config('tracking.analytics.key') && Visitor::isEuropean())
        <x-ark-pages-includes-cookie-banner
            :domain="$cookieDomain"
            :contact-url="$cookieContactUrl"
            :disable-outside-click="$disableCookieOutsideClick"
            :overlay-cross-button="$overlayCookieCrossButton"
        />
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
