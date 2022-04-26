@props([
    'name',
    'route'         => null,
    'onClick'       => null,
    'params'        => [],
    'icon'          => null,
    'iconAlignment' => 'right',
    'href'          => null,
    'active'        => false
])

@php ($isCurrent = ($route && url()->full() === route($route, $params)))

<div class="flex">
    <div class="@if($isCurrent || $active) bg-theme-primary-600 rounded-xl @endif w-2 -mr-1 z-10"></div>

    <a
        @if($onClick)
            type="button"
            x-on:click="{{ $onClick }}"
        @elseif ($href)
            href="{{ $href }}"
        @else
            href="{{ route($route, $params) }}"
        @endif
        @class([
            'flex items-center block font-semibold pl-8 py-4 space-x-2 rounded-r w-full group transition-default',
            'dark:bg-theme-secondary-800 dark:text-theme-secondary-200 text-theme-primary-600 bg-theme-primary-100' => $isCurrent || $active,
            'text-theme-secondary-900 hover:text-theme-primary-600 dark:text-theme-secondary-200 dark:hover:text-theme-primary-600' => ! $isCurrent,
            'cursor-pointer' => $onClick,
        ])
        dusk='navbar-item-{{ Str::slug($name) }}'
        {{ $attributes->except(['href', 'class', 'dusk']) }}
    >

        @if ($icon && $iconAlignment === 'left')
            <x-ark-icon
                :class="Arr::toCssClasses([
                    'mr-1 flex-shrink-0 transition-default',
                    'text-theme-primary-600 dark:text-theme-secondary-200' => $isCurrent || $active,
                    'text-theme-primary-300 dark:text-theme-secondary-600 group-hover:text-theme-primary-600' => ! $isCurrent || $active,
                ])"
                :name="$icon"
            />
        @endif

        <span>{{ $name }}</span>

        @if ($icon && $iconAlignment === 'right')
            <x-ark-icon
                :class="Arr::toCssClasses([
                    'flex-shrink-0 transition-default',
                    'text-theme-primary-600 dark:text-theme-secondary-200' => $isCurrent || $active,
                    'text-theme-primary-300 dark:text-theme-secondary-600 group-hover:text-theme-primary-600' => ! $isCurrent || $active,
                ])"
                :name="$icon"
            />
        @endif
    </a>
</div>

