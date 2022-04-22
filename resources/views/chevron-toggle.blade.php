@props([
    'isOpen',
    'size' => 'xs',
    'openClass' => null,
])

<span
    {{ $attributes->class('transition duration-150 ease-in-out') }}
    :class="{ 'rotate-180 {{ Arr::toCssClasses([
        'rotate-180',
        $openClass
    ]) }}': {{ $isOpen }} }"
>
    <x-ark-icon name="arrows.chevron-down-small" :size="$size" />
</span>
