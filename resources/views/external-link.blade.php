@props([
    'url',
    'text',
    'class'  => 'link font-semibold inline break-words',
    'innerClass' => '',
    'small'  => false,
    'noIcon' => false,
])

<a
    href="{{ $url }}"
    class="{{ $class }}"
    target="_blank"
    rel="noopener nofollow noreferrer"
>
    <span @class($innerClass)">
        {{ isset($slot) && trim($slot) ? $slot : $text }}
    </span>

    @unless($noIcon)
        <x-ark-icon
            name="arrows.arrow-external"
            size="xs"
            class="inline relative -top-1 flex-shrink-0 mt-1 ml-0.5 text-theme-secondary-500"
        />
    @endunless
</a>
