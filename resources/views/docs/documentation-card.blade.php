@props([
    'url',
    'text',
    'icon',
    'disabled' => false,
    'tooltip' => trans('tooltips.coming-soon'),
])

<a
    @if($disabled)
        data-tippy-content="{{ $tooltip }}"
        href="#"
    @else
        href="{{ $url }}"
    @endif
    {{ $attributes->class([
        'documentation-card flex flex-col items-center justify-between font-normal px-10 py-5 rounded-lg transition-default',
        'border-2 border-theme-primary-100 hover:border-theme-primary-700 hover:bg-theme-primary-700 hover:text-white' => !$disabled,
        'documentation-card-disabled border border-theme-secondary-300 text-theme-secondary-500 select-none cursor-default' => $disabled,
    ]) }}
>
    <x-ark-icon name="home-{{ $icon }}" size="h-13" class=" documentation {{ $disabled ? 'disabled' : '' }}" />

    <div class="flex flex-col">
        <span class="mt-3 font-semibold text-center">{{ $text }}</span>
    </div>
</a>
