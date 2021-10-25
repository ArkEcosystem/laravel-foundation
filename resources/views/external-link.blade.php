@props([
    'url',
    'text',
    'class'         => 'link font-semibold inline break-words',
    'small'         => false,
    'noIcon'        => false,
    'noIconTooltip' => null,
    'tooltip'       => null,
])

<a
    href="{{ $url }}"
    class="{{ $class }}"
    target="_blank"
    rel="noopener nofollow noreferrer"
>
    <span @if($tooltip) data-tippy-content="{{ $tooltip }}" @endif>{{ isset($slot) && trim($slot) ? $slot : $text }}</span>

    @unless($noIcon)
        <div @if($noIconTooltip) data-tippy-content="{{ $noIconTooltip }}" @endif>
            <x-ark-icon
                name="link"
                :size="$small ? 'xs' : 'sm'"
                :class="'flex-shrink-0 inline relative ml-0.5 ' . ($small ? '-top-1 -mt-0.5' : '-mt-1.5')"
            />
        </div>
    @endunless
</a>
