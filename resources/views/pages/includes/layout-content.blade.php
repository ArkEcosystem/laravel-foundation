@props([
    'slim'           => false,
    'slimClass'      => 'px-8 lg:max-w-7xl',
    'verticalCenter' => false,
])

<main {{ $attributes->class([
    'container flex flex-col flex-1 w-full mx-auto sm:max-w-full',
    'flex flex-col' => $verticalCenter,
    $slimClass => $slim,
]) }}>
    <div @class([
        'w-full bg-white dark:bg-theme-secondary-900 h-full',
        'flex flex-col flex-1' => $verticalCenter,
    ])>
        {{ $slot }}
    </div>
</main>
