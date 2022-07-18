@props([
    'slim'         => false,
    'slimClass'    => 'px-8 lg:max-w-7xl',
    'contentClass' => 'bg-white dark:bg-theme-secondary-900',
])

<main {{ $attributes->class([
    'container flex-1 w-full mx-auto sm:max-w-full',
    $slimClass => $slim,
]) }}>
    <div @class(['w-full'. $contentClass])>
        {{ $slot }}
    </div>
</main>
