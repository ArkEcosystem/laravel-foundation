@props([
    'class'             => 'rounded',
    'dimensions'        => 'w-48 h-48',
    'spinnerDimensions' => 'w-20 h-20',
])

<div class="cursor-pointer flex items-center justify-center absolute top-0 opacity-90 transition-default bg-theme-secondary-900 {{ $dimensions }} {{ $class }}">
    <x-ark-icon name="circle.spinner" class=" {{ $spinnerDimensions }} text-white animation-spin duration-1000" />
</div>
