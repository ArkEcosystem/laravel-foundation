@props([
    'height'     => 'h-px',
    'colorClass' => 'bg-theme-secondary-300 text-theme-secondary-300 dark:bg-theme-secondary-800',
])

<hr {{ $attributes->class([
    'w-full border-none',
    $colorClass,
    $height,
]) }} />
