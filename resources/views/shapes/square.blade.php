@props([
    'colorClass'   => 'bg-theme-secondary-200 dark:bg-theme-secondary-900',
    'sizeClass'    => 'w-20 h-20',
    'roundedClass' => 'rounded-xl',
])

<div>
    <div @class([
        $colorClass,
        $sizeClass,
        $roundedClass,
    ])></div>
</div>
