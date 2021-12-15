@props(['height' => 'h-px'])

<hr {{ $attributes->class([
    'bg-theme-secondary-300 text-theme-secondary-300 w-full border-none dark:bg-theme-secondary-800',
    $height,
]) }} />
