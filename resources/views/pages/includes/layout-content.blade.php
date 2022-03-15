@props([
    'slim'      => false,
    'slimClass' => 'px-8 lg:max-w-7xl',
])

<main {{ $attributes->class([
    'container flex-1 w-full mx-auto sm:max-w-full',
    $slimClass => $slim,
]) }}>
    <div class="w-full bg-white dark:bg-theme-secondary-900">
        {{ $slot }}
    </div>
</main>
