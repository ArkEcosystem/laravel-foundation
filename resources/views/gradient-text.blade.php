@props ([
    'from',
    'via' => null,
    'to',
    'direction' => 'right',
    'animated' => false,
    'animationSpeed' => '15s',
])

<span
    style="
        @if ($animated)
            @if ($via === null)
                --tw-gradient-from: {{ $from }};
                --tw-gradient-to: {{ $from }};
                --tw-gradient-stops: var(--tw-gradient-from), {{ $to }}, var(--tw-gradient-to, {{ $from }});
            @else
                --tw-gradient-from: {{ $from }};
                --tw-gradient-to: {{ $from }};
                --tw-gradient-stops: var(--tw-gradient-from), {{ $via }}, {{ $to }}, var(--tw-gradient-to, {{ $from }});
            @endif

            animation: move-bg {{ $animationSpeed }} infinite linear;
        @else
            @if ($via === null)
                --tw-gradient-from: {{ $from }};
                --tw-gradient-to: {{ $to }};
                --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, {{ $to }});
            @else
                --tw-gradient-from: {{ $from }};
                --tw-gradient-to: {{ $to }};
                --tw-gradient-stops: var(--tw-gradient-from), {{ $via }}, var(--tw-gradient-to, {{ $to }});
            @endif
        @endif
    "
    {{ $attributes->class([
        'text-transparent bg-clip-text inline-block',
        'bg-gradient-to-r' => $direction === 'right',
        'bg-gradient-to-l' => $direction === 'left',
        'bg-gradient-to-b' => $direction === 'bottom',
        'bg-gradient-to-t' => $direction === 'top',
        'gradient-title-moving' => $animated,
    ]) }}
>
    {{ $slot }}
</span>
