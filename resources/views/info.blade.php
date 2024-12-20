@props([
    'class' => '',
    'tooltip' => '',
    'htmlTooltip' => null,
    'type' => 'question',
    'large' => false
])

<div
    @if ($tooltip)
        data-tippy-content="{{ $tooltip }}"
    @elseif ($htmlTooltip)
        data-tippy-html-content="{{ $htmlTooltip }}"
    @endif

    aria-label="{{ $tooltip }}"
    class="inline-block cursor-pointer {{ $large ? 'p-1.5' : 'p-1' }} transition-default rounded-full bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-600 hover:text-white hover:bg-theme-primary-700 dark:hover:text-theme-secondary-800 dark:hover:bg-theme-secondary-600 outline-none focus-visible:ring-2 focus-visible:ring-theme-primary-500 {{ $class }}"
    tabindex="0"
>
    @if($type === 'question')
        <x-ark-icon name="question-mark-small" size="{{ $large ? 'sm' : 'xs' }}" />
    @else
        <x-ark-icon name="hint-small" size="{{ $large ? 'sm' : 'xs' }}" />
    @endif
</div>
