@props([
    'isOpen',
    'size' => 'xs',
    'openClass' => null,
    'closedClass' => null,
])

<span
    {{ $attributes->class('transition duration-150 ease-in-out') }}
    :class="{
        '{{ Arr::toCssClasses(['rotate-180', $openClass]) }}': {{ $isOpen }},
        '{{ Arr::toCssClasses([$closedClass]) }}': ! ({{ $isOpen }}),
    }"
>
    <x-ark-icon name="arrows.chevron-down-small" :size="$size" />
</span>
