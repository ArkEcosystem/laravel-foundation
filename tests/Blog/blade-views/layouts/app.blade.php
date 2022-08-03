<div id="app">
    {{ $slot ?? null }}

    @if (($content ?? null) === null)
        @yield('content')
    @else
        {{ $content ?? null }}
    @endif
</div>
