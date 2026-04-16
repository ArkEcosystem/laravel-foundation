@props([
    'url',
    'icon',
    'label' => null,
    'class' => 'hover:text-theme-primary-700',
])

<a
    {{ $attributes->class(['rounded transition-default', $class]) }}
    href="{{ $url }}"
    target="_blank"
    rel="noopener noreferrer"
    @if ($label)
        aria-label="{{ $label }}"
        title="{{ $label }}"
    @endif
>
    <x-ark-icon :name="$icon" size="sm" aria-hidden="true" />

    @if ($label)
        <span class="sr-only">{{ $label }}</span>
    @endif
</a>
