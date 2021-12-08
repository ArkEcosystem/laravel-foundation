@props([
    'id',
    'data',
    'labels',
    'currency',
    'canvasClass' => '',
    'width' => '1000',
    'height' => '500',
    'grid' => false,
    'tooltips' => false,
    'theme' => collect(['name' => 'grey', 'mode' => 'light']),
])

<div
    x-data="CustomChart(
        '{{ $id }}',
        {{ $data }},
        {{ $labels }},
        '{{ $grid }}',
        '{{ $tooltips }}',
        {{ json_encode($theme->toArray()) }},
        '{{ time() }}',
        '{{ $currency }}',
    )"
    wire:key="{{ $id.time() }}"
    {{ $attributes->only('class') }}
>
    <div wire:ignore class="relative w-full h-full">
        <canvas
            x-ref="{{ $id }}"
            @if($canvasClass) class="{{ $canvasClass }}" @endif
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
        ></canvas>
    </div>
</div>
