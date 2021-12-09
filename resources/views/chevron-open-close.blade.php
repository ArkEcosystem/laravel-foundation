@props([
    'isOpen',
    'size' => 'xs',
])

<div class="inline-flex">
    <span
        {{ $attributes->class('transition duration-150 ease-in-out transform') }}
        :class="{ 'rotate-180': {{ $isOpen }} }"
    >
        <x-ark-icon name="chevron-down" :size="$size" />
    </span>
</div>
