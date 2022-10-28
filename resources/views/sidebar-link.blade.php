@props([
    'name',
    'route' => null,
    'params' => [],
    'active' => null,
    'icon' => null,
    'iconAlignment' => 'right',
    'href' => null,
    'active' => false,
    'rounded' => true,
    'attrs' => [],
    'itemClass'       => 'text-theme-secondary-900 hover:text-theme-primary-600 dark:text-theme-secondary-200 dark:hover:text-theme-primary-600',
    'activeItemClass' => 'dark:bg-theme-secondary-800 dark:text-theme-secondary-200 text-theme-primary-600 bg-theme-primary-100',
    'iconColors' => 'text-theme-primary-300 dark:text-theme-secondary-600 group-hover:text-theme-primary-600',
    'activeIconColors' => 'text-theme-primary-600 dark:text-theme-secondary-200',
])

@php
    $isCurrent = ($route && url()->full() === route($route, $params));

    if ($active !== null) {
        $isCurrent = $active;
    }
@endphp

<div class="flex">
    <div @class([
        'w-1 -mr-1 z-10',
        'bg-theme-primary-600' => $isCurrent || $active,
        'rounded-xl' => $rounded && ($isCurrent || $active),
    ])></div>

    <a
        @if ($href)
            href="{{ $href }}"
        @else
            href="{{ route($route, $params) }}"
        @endif
        @class([
            'flex items-center block font-semibold pl-8 py-4 space-x-2 rounded-r w-full group transition-default',
            $activeItemClass => $isCurrent || $active,
            $itemClass => ! $isCurrent,
        ])
        dusk='navbar-item-{{ Str::slug($name) }}'
        @foreach($attrs as $attribute => $attributeValue)
            {{ $attribute }}="{{ $attributeValue }}"
        @endforeach
        {{ $attributes->except(['href', 'class', 'dusk']) }}
    >

        @if ($icon && $iconAlignment === 'left')
            <x-ark-icon
                :class="Arr::toCssClasses([
                    'mr-1 flex-shrink-0 transition-default',
                    $activeIconColors => $isCurrent || $active,
                    $iconColors => ! $isCurrent || $active,
                ])"
                :name="$icon"
            />
        @endif

        <span>{{ $name }}</span>

        @if ($icon && $iconAlignment === 'right')
            <x-ark-icon
                :class="Arr::toCssClasses([
                    'flex-shrink-0 transition-default',
                    $activeIconColors => $isCurrent || $active,
                    $iconColors => ! $isCurrent || $active,
                ])"
                :name="$icon"
            />
        @endif
    </a>
</div>

