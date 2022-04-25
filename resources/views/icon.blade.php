@props([
    'name',
    'size' => 'base',
    'style' => null,
    'class' => null
])
@php
    $sizes = [
        '2xs'  => 'w-2 h-2',
        'xs'   => 'w-3 h-3',
        'sm'   => 'w-4 h-4',
        'md'   => 'w-6 h-6',
        'lg'   => 'w-8 h-8',
        'xl'   => 'w-12 h-12',
        '2xl'  => 'w-14 h-14',
        '3xl'  => 'w-15 h-15',
        'base' => 'w-5 h-5',
    ];

    if (empty($size) || in_array($size, array_keys($sizes))) {
        $size = $sizes[$size ?? 'base'];
    }

    if (!empty($style)) {
        $style = [
            'secondary' => 'text-theme-secondary-500',
            'success'   => 'text-theme-success-500',
            'danger'    => 'text-theme-danger-500',
        ][$style];
    }
@endphp

@svg($name, collect([$size, $style, $class])->filter()->join(' '), ['wire:key' => Str::random(8)])
