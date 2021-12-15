@props([
    'name',
    'route' => null,
    'params' => [],
    'attributes' => [],
    'icon' => null,
    'iconAlignment' => 'right',
    'href' => null,
])

@php ($isCurrent = $route && url()->full() === route($route, $params))

<div class="flex">
    <div class="@if($isCurrent) bg-theme-primary-600 rounded-xl @endif w-2 -mr-1 z-10"></div>

    <a
        @if ($href)
            href="{{ $href }}"
        @else
            href="{{ route($route, $params) }}"
        @endif
        class="flex items-center block font-semibold pl-8 py-4 space-x-2 @if($isCurrent) dark:bg-theme-secondary-800 dark:text-theme-secondary-200 text-theme-primary-600 bg-theme-primary-100 @else text-theme-secondary-900 hover:text-theme-primary-600 dark:text-theme-secondary-200 dark:hover:text-theme-primary-600 @endif rounded-r w-full group transition-default"
        dusk='navbar-item-{{ Str::slug($name) }}'
        @foreach($attributes as $attribute => $attributeValue)
            {{ $attribute }}="{{ $attributeValue }}"
        @endforeach
    >

        @if ($icon && $iconAlignment === 'left')
            <x-ark-icon class="{{ $isCurrent ? 'text-theme-primary-600 dark:text-theme-secondary-200' : 'text-theme-primary-300 dark:text-theme-secondary-600 group-hover:text-theme-primary-600' }}  mr-1 transition-default" :name="$icon" />
        @endif

        <span>{{ $name }}</span>

        @if ($icon && $iconAlignment === 'right')
            <x-ark-icon class="{{ $isCurrent ? 'text-theme-primary-600 dark:text-theme-secondary-200' : 'text-theme-primary-300 dark:text-theme-secondary-600 group-hover:text-theme-primary-600' }}  transition-default" :name="$icon" />
        @endif
    </a>
</div>
