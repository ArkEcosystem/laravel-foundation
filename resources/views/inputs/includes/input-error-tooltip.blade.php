@props([
    'error',
    'id',
    'shifted' => false,
    'tippyTriggerTarget' => false,
    'tippyToggleFocus' => false,
])

<button
    type="button"
    wire:key="{{ md5($id.$error) }}"
    @class([
        'px-4 input-icon focus-visible:rounded',
        'right-13' => $shifted,
        'right-0'  => ! $shifted,
    ])
    data-tippy-content="{{ $error }}"
    onclick="document.getElementById('{{ $id }}').focus()"
    @if ($tippyTriggerTarget)
        data-tippy-trigger-target="{{ $tippyTriggerTarget }}"
        tabindex="-1"
    @endif
    @if ($tippyToggleFocus)
        data-tippy-toggle-focus="true"
    @endif
>
    <x-ark-icon name="report" class="text-theme-danger-500" />
    @if($shifted)
        <div class="w-px h-5 transform translate-x-4 bg-theme-secondary-300 dark:bg-theme-secondary-800">&nbsp;</div>
    @endif
</button>
