@props([
    'maskIconColor',
    'microsoftTileColor',
    'themeColor',
    'defaultName' => config('app.name', 'ARK'),
    'viewport' => 'width=device-width, initial-scale=1.0',
])

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="{{ $viewport }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (config('ui.dark-mode.enabled') === true)
        <x-ark-dark-theme-script />
    @endif

    <!-- Favicon -->
    @unless (isset($favicons))
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="{{ $maskIconColor }}">
        <meta name="msapplication-TileColor" content="{{ $microsoftTileColor }}">
        <meta name="theme-color" content="{{ $themeColor }}">
    @else
        {{ $favicons }}
    @endunless

    <!-- Fonts -->
    <x-ark-font-loader src="https://rsms.me/inter/inter.css" />

    {{ $slot }}

    <!-- Styles -->
    @vite('resources/css/app.css')
    @livewireStyles

    @if (config('tracking.analytics.key') && Visitor::isEuropean())
        <link href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.5.1/dist/cookieconsent.css" rel="stylesheet">
    @endif

    @stack('scripts')
</head>
