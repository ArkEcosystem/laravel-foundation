@props([
    'isOpen',
    'size' => 'xs',
])

<span 
    {{ $attributes->class('transition duration-150 ease-in-out transform') }}
    :class="{ 'rotate-180': {{ $isOpen }} }"
>
    <x-ark-icon name="chevron-down" :size="$size" />
</span>
