@props([
    'includes' => null,
    'footer'   => null,
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
</body>
