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
        '1' => 'pt-1 mt-1',
        '2' => 'pt-2 mt-2',
        '3' => 'pt-3 mt-3',
        '4' => 'pt-4 mt-4',
        '5' => 'pt-5 mt-5',
        '6' => 'pt-6 mt-6',
        '7' => 'pt-7 mt-7',
        '8' => 'pt-8 mt-8',
        default => 'pt-8 mt-8',
    };

    // Determines whether `class` attribute manually sets the color of the separator...
    // If not, it will default to `border-theme-secondary-300`.
    // Example:
    // `<x-ark-separator class="border-theme-primary-400" />`
    // `<x-ark-separator />`
    preg_match('/border-theme-[a-zA-Z0-9-]+/', $attributes->get('class', ''), $matches);
@endphp

<hr {{ $attributes->class([
    $typeClass,
    $spacingClass,
    'border-theme-secondary-300' => count($matches) === 0,
]) }} />
