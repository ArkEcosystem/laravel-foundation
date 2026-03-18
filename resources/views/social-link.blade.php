@props([
    'url',
    'icon',
    'label' => null,
])

<a
    {{ $attributes }}
    href="{{ $url }}"
    target="_blank"
    rel="noopener noreferrer"
    class="rounded transition-default hover:text-theme-secondary-200"
    @if ($label) aria-label="{{ $label }}" @endif
>
    <x-ark-icon :name="$icon" size="sm" aria-hidden="true" />

    @if ($label)
        <span class="sr-only">{{ $label }}</span>
    @endif
</a>
