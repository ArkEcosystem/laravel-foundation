@props([
    'inverted'   => false,
    'breakpoint' => 'md',
])

@php
    // Exact class strings required to prevent purging
    $breakpointClass = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$breakpoint];

    $invertedSeparator = match ($inverted) {
        true => 'border-theme-primary-700 inverted:border-theme-secondary-300 ',
        false => 'border-theme-secondary-300 dark:border-theme-secondary-800 ',
    };
@endphp

<div class="flex items-center {{ $breakpointClass }}">
    <button @click="open = !open" class="inline-flex relative justify-center items-center p-2 rounded-md transition duration-400 ease-in-out inverted:text-theme-secondary-900 inverted:hover:bg-theme-primary-100 inverted:hover:text-theme-primary-700 text-theme-primary-100 hover:text-white hover:bg-theme-primary-400">
        <span :class="{ 'hidden': open, 'inline-flex': !open }">
            <x-ark-icon name="menu" size="sm" />
        </span>

        <span :class="{ 'hidden': !open, 'inline-flex': open }" x-cloak>
            <x-ark-icon name="menu-show" size="sm" />
        </span>
    </button>

    <span class="block pr-7 ml-7 h-7 border-l transition duration-400 {{ $invertedSeparator }}"></span>
</div>
