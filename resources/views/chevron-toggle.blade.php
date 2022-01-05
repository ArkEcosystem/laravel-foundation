@props([
    'isOpen',
    'size' => 'xs',
])

<span
    {{ $attributes->class('transition duration-150 ease-in-out') }}
    :class="{ 'rotate-180': {{ $isOpen }} }"
>
    <x-ark-icon name="arrows.chevron-down-small" :size="$size" />
</span>
