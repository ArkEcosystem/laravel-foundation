@props([
    'icon',
    'position' => 'right',
    'iconClass' => '',
    'iconSize' => 'base',
])

@php
    $positionClasses = [
        'left' => 'left-0 ml-3',
        'right' => 'right-0 mr-3',
        'base' => 'right-0 mr-3',
    ][$position];
@endphp

<div class="input-prefix-icon {{ $positionClasses }} {{ $iconClass }}">
    <x-ark-icon :name="$icon" :size="$iconSize" />
</div>
