@props([
    'title'        => null,
    'description'  => null,
    'contentClass' => 'flex flex-col items-center text-center space-y-4 contact-header',
])

<div {{ $attributes->class('bg-theme-secondary-100 dark:bg-black') }}>
    <div @class([$contentClass])>
        <h1 class="mb-0">{{ $title }}</h1>

        @if (strlen($description) > 0)
            <div class="text-lg font-semibold">
                {{ $description }}
            </div>
        @endif
    </div>
</div>
