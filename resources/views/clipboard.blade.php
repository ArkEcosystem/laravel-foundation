<div
    x-data="clipboard()"
    x-init="initClipboard()"
    class="{{ $wrapperClass ?? '' }}"
>
    <button
        type="button"
        class="clipboard @unless($noStyling ?? false) button-icon @endif {{ $class ?? 'h-10 w-12' }}"
        tooltip-content="{{ ($tooltipContent ?? '') ? $tooltipContent : trans('tooltips.copied') }}"
        @if($copyInput ?? false)
            x-on:click="copyFromInput('{{ $value }}')"
        @else
            x-on:click="copy('{{ $value }}')"
        @endif
    >
        <x-ark-icon name="copy" size="sm" />
    </button>
</div>
