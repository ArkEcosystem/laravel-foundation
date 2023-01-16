@props([
    'colorClass'   => 'bg-theme-secondary-200 dark:bg-theme-secondary-800',
    'sizeClass'    => 'w-20 h-20',
    'roundedClass' => 'rounded',
    'pulse'        => false,
])

<div>
    <div {{ $attributes->class([
        $colorClass,
        $sizeClass,
        $roundedClass,
        'animate-pulse' => $pulse,
    ]) }}>
        {{ $slot }}
    </div>
</div>
