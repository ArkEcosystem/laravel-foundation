@props([
    'icon',
    'url',
    'internal'   => false,
    'class'      => 'w-16 border h-14 border-theme-secondary-300 lg:w-14 lg:h-12 dark:border-theme-secondary-800',
    'hoverClass' => 'hover:bg-theme-danger-400 hover:text-white',
    'iconSize'   => 'w-6 h-6 lg:w-5 lg:h-5',
])

<a
    {{ $attributes->merge([
        'href'  => $url,
        'class' => Arr::toCssClasses([
            'block rounded-xl cursor-pointer transition-default',
            $class,
            $hoverClass,
        ]),
    ]) }}
    @unless($internal)
        target="_blank"
        rel="noopener noreferrer"
    @endunless
>
    <div class="flex justify-center items-center h-full">
        <x-ark-icon
            :name="$icon"
            :size="$iconSize"
        />
    </div>
</a>
