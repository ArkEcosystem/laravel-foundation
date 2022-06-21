@props([
    'inverted'       => false,
    'noSeparator'    => false,
    'separatorClass' => null,
    'breakpoint'     => 'md',
    'color'          => 'hover:bg-theme-primary-400 hover:text-white text-theme-secondary-900',
    'invertedColor'  => 'inverted:text-theme-secondary-900 inverted:hover:text-theme-primary-700 text-theme-primary-100',
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
        true => 'border-theme-primary-700 inverted:border-theme-secondary-300',
        false => 'border-theme-secondary-300 dark:border-theme-secondary-800',
    };

    $invertedColour = match ($inverted) {
        true => 'inverted:hover:bg-theme-primary-100 '.$invertedColor,
        false => $color,
    };
@endphp

<div class="flex items-center {{ $breakpointClass }}">
    <button
        @click="open = !open"
        @class([
            'inline-flex relative justify-center items-center py-2 px-3 h-11 rounded-md transition ease-in-out md:px-5 duration-400',
            $invertedColour,
        ])
    >
        <span :class="{ 'hidden': open, 'inline-flex': !open }">
            <x-ark-icon name="menu" />
        </span>

        <span :class="{ 'hidden': !open, 'inline-flex': open }" x-cloak>
            <x-ark-icon name="menu-show" />
        </span>
    </button>

    @unless($noSeparator)
        <span @class([
            'block pr-6 md:pr-8 ml-3 h-7 border-l transition duration-400',
            $invertedSeparator,
            $separatorClass,
        ])></span>
    @endunless
</div>
