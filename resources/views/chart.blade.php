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
    'yPadding' => 15,
    'xPadding' => 10,
    'showCrosshair' => false,
    'tooltipHandler' => null,
    'hasDateTimeLabels' => null,
    'dateUnitOverride' => null,
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
        {{ $yPadding }},
        {{ $xPadding }},
        {{ $showCrosshair ? 'true' : 'false' }},
        {{ $tooltipHandler ? $tooltipHandler : 'null' }},
        {{ $hasDateTimeLabels ? 'true' : 'false' }},
        @if ($dateUnitOverride)
            '{{ $dateUnitOverride }}',
        @else
            null,
        @endif
    )"
    wire:key="{{ $id.time() }}"
    {{ $attributes->only('class') }}
>
    <div
        class="relative w-full h-full"
        wire:ignore
    >
        <canvas
            x-ref="{{ $id }}"
            @if($canvasClass) class="{{ $canvasClass }}" @endif
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
        ></canvas>
    </div>
</div>
