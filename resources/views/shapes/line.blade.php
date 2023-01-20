@props([
    'colorClass'   => 'bg-theme-secondary-200 dark:bg-theme-secondary-800',
    'sizeClass'    => 'w-full h-5',
    'roundedClass' => 'rounded',
    'pulse'        => false,
])

<div>
    <div {{ $attributes->class([
        $colorClass,
        $sizeClass,
        $roundedClass,
        'animate-pulse' => $pulse,
    ]) }}></div>
</div>
