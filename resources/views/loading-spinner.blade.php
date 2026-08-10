@props([
    'class' => 'rounded',
    'dimensions' => 'w-48 h-48',
    'spinnerDimensions' => 'w-20 h-20',
])

<div
    class="transition-default {{ $dimensions }} {{ $class }} absolute top-0 flex cursor-pointer items-center justify-center bg-theme-secondary-900 opacity-90">
    <x-ark-icon name="circle.spinner" class="{{ $spinnerDimensions }} animation-spin text-white duration-1000" />
</div>
