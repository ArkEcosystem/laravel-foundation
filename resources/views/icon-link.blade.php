@props([
    'href',
    'target' => '_self',
    'rel'    => '',
    'hideIcon' => false,
])

<a
    href="{{ $href }}"
    target="{{ $target }}"
    rel="{{ $rel }}"
    class="flex items-center space-x-2 font-semibold link"
>
    @unless($hideIcon)
        <span><x-ark-icon name="arrows.arrow-external" size="sm" /></span>
    @endunless

    <span>{{ $slot }}</span>
</a>
