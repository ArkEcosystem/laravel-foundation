@props([
    'url',
    'text',
    'class'     => 'link font-semibold inline break-words',
    'small'     => false,
    'noIcon'    => false,
])

<a
    href="{{ $url }}"
    class="{{ $class }}"
    target="_blank"
    rel="noopener nofollow noreferrer"
>
    <span>{{ isset($slot) && trim($slot) ? $slot : $text }}</span>

    @unless($noIcon)
        <x-ark-icon
            name="arrows.arrow-external"
            size="xs"
            class="flex-shrink-0 inline relative ml-0.5 -top-1 -mt-0.5 text-theme-secondary-500"
        />
    @endunless
</a>
