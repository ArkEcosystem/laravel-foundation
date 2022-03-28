@props ([
    'type' => 'line',
    'spacing' => 8,
])

@php
    $typeClass = match ($type) {
        'bold' => 'border-t-2',
        'dotted' => 'border-t-4 border-dotted',
        'dashed' => 'border-t border-dashed',
        'line' => 'border-t',
        default => 'border-t',
    };

    $spacingClass = match ((string) $spacing) {
        '1' => 'my-1',
        '2' => 'my-2',
        '3' => 'my-3',
        '4' => 'my-4',
        '5' => 'my-5',
        '6' => 'my-6',
        '7' => 'my-7',
        '8' => 'my-8',
        default => 'my-8',
    };
@endphp

<hr {{ $attributes->class([
    $typeClass,
    $spacingClass,
    'custom-separator border-theme-secondary-300 dark:border-theme-secondary-800',
]) }} />
