@props([
    'class' => '',
    'tooltip' => '',
    'htmlTooltip' => null,
    'type' => 'question',
    'large' => false,
])

<div @if ($tooltip) data-tippy-content="{{ $tooltip }}"
    @elseif ($htmlTooltip)
        data-tippy-html-content="{{ $htmlTooltip }}" @endif
    aria-label="{{ $tooltip }}"
    class="{{ $large ? 'p-1.5' : 'p-1' }} transition-default {{ $class }} inline-block cursor-pointer rounded-full bg-theme-primary-100 text-theme-primary-600 outline-none hover:bg-theme-primary-700 hover:text-white focus-visible:ring-2 focus-visible:ring-theme-primary-500 dark:bg-theme-secondary-800 dark:text-theme-secondary-600 dark:hover:bg-theme-secondary-600 dark:hover:text-theme-secondary-800"
    tabindex="0">
    @if ($type === 'question')
        <x-ark-icon name="question-mark-small" size="{{ $large ? 'sm' : 'xs' }}" />
    @else
        <x-ark-icon name="hint-small" size="{{ $large ? 'sm' : 'xs' }}" />
    @endif
</div>
