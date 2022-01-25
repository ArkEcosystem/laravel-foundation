@props([
    'fullWidth',
    'fullWidthClass' => 'px-8 lg:max-w-7xl',
])

<main {{ $attributes->class([
    'container flex-1 w-full mx-auto sm:max-w-full',
    $fullWidthClass => ! $fullWidth,
]) }}>
    <div class="w-full bg-white dark:bg-theme-secondary-900">
        {{ $slot }}
    </div>
</main>
