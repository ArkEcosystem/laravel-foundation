@props([
    'maskIconColor',
    'microsoftTileColor',
    'themeColor',
    'defaultName' => config('app.name', 'ARK'),
])

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trim(View::yieldContent('title', $defaultName)) }}</title>

    @if (config('ui.dark-mode.enabled') === true)
        <x-ark-dark-theme-script />
    @endif

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="{{ $maskIconColor }}">
    <meta name="msapplication-TileColor" content="{{ $microsoftTileColor }}">
    <meta name="theme-color" content="{{ $themeColor }}">

    <!-- Meta --->
    <x-ark-metadata-tags>
        <x-slot name="title">@yield('meta-title', trans('metatags.home.title'))</x-slot>
        <x-slot name="description">@yield('meta-description', trans('metatags.home.description'))</x-slot>
        <x-slot name="image">@yield('meta-image', trans('metatags.home.image'))</x-slot>
    </x-ark-metadata-tags>

    <!-- Fonts -->
    <x-ark-font-loader src="https://rsms.me/inter/inter.css" />

    {{ $slot }}

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles

    @stack('scripts')
</head>
