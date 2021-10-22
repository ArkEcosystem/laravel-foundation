@props ([
    'value',
    'class'          => 'h-10 w-12',
    'copyInput'      => false,
    'noStyling'      => false,
    'tooltipContent' => trans('tooltips.copied'),
    'wrapperClass'   => '',
])

<div
    x-data="clipboard()"
    x-init="initClipboard()"
    class="{{ $wrapperClass }}"
>
    <button
        type="button"
        class="clipboard @unless($noStyling) button-icon @endif {{ $class }}"
        tooltip-content="{{ $tooltipContent }}"
        @if($copyInput)
            x-on:click="copyFromInput('{{ $value }}')"
        @else
            x-on:click="copy('{{ $value }}')"
        @endif
    >
        <x-ark-icon name="copy" size="sm" />
    </button>
</div>
