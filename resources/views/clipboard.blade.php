@props ([
    'value',
    'class'           => 'h-10 w-12',
    'copyInput'       => false,
    'noStyling'       => false,
    'tooltipContent'  => trans('tooltips.copied'),
    'wrapperClass'    => '',
    'withCheckmarks'  => false,
    'checkmarksClass' => null,
])

<div
    x-data="clipboard({{ $withCheckmarks ? 'true' : 'false' }})"
    x-init="initClipboard()"
    @class($wrapperClass)
>
    <button
        type="button"
        @class([
            'clipboard relative',
            'button-icon' => ! $noStyling,
            $class,
        ])
        tooltip-content="{{ $tooltipContent }}"
        @if($copyInput)
            x-on:click="copyFromInput('{{ $value }}')"
        @else
            x-on:click="copy('{{ $value }}')"
        @endif
    >
        @unless ($withCheckmarks)
            <x-ark-icon
                name="copy"
                size="sm"
            />
        @else
            <div
                :class="{ 'opacity-0': showCheckmarks }"
                class="transition-default"
            >
                <x-ark-icon
                    name="copy"
                    size="sm"
                />
            </div>

            <div
                x-show="showCheckmarks"
                @class([
                    'absolute m-auto',
                    $checkmarksClass,
                ])
                x-cloak
                x-transition
            >
                <x-ark-icon
                    name="double-check-mark"
                    size="sm"
                />
            </div>
        @endif
    </button>
</div>
