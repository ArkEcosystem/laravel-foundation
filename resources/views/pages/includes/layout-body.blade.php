@props([
    'includes'     => null,
    'footer'       => null,
    'content'      => null,
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

        @if ($content === null)
            <x-ark-pages-includes-layout-content>
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

    @livewireScripts

    @livewire('toast')

    {{ $includes }}

    @stack('extraStyle')

    @stack('footer')

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    @if (config('tracking.analytics.key') && Visitor::isEuropean())
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
