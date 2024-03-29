@props([
    'init' => false,
    'xData' => '{}',
    'class' => '',
    'widthClass' => 'max-w-full md:max-w-2xl',
    'contentClass' => null,
    'title' => null,
    'titleClass' => 'inline-block pb-3 font-bold dark:text-theme-secondary-200',
    'buttons' => null,
    'buttonsStyle' => 'modal-buttons',
    'closeButtonOnly' => false,
    'escToClose' => true,
    'disableOutsideClick' => false,
    'name' => '',
    'backdrop' => null,
    'square' => false,
    'hideCross' => false,
    'padding' => 'p-8 sm:p-10',
    'breakpoint' => 'md',
    'closeButtonClass' => 'absolute top-0 right-0 p-0 mt-0 mr-0 w-11 h-11 rounded-none sm:mt-6 sm:mr-6 sm:rounded button button-secondary text-theme-secondary-900',
])

@php
    $contentWrapperBreakpointClass = [
        'sm' => 'sm:m-auto',
        'md' => 'md:m-auto',
    ][$breakpoint] ?? 'md:m-auto';
@endphp

<div
    {{ $attributes }}
    x-ref="modal"
    data-modal="{{ $name }}"
    x-cloak
    @if($init)
        x-data="Modal.alpine({{ $xData }}, '{{ $name }}')"
    @endif

    @if(!$closeButtonOnly && $escToClose)
        @keydown.escape="hide"
        tabindex="0"
    @endif
    x-show="shown"
    class="flex overflow-y-auto fixed inset-0 z-50 md:py-10 md:px-8"
>
    @if ($backdrop)
        {{ $backdrop }}
    @else
        <div class="fixed inset-0 opacity-75 dark:opacity-50 bg-theme-secondary-900 dark:bg-theme-secondary-800"></div>
    @endif

    <div
        @class([
            'w-full',
            $class,
            $widthClass,
            $contentWrapperBreakpointClass,
        ])"
        @if(! $closeButtonOnly && ! $disableOutsideClick)
            @click.outside="hide"
        @endif
    >
        <div @class([
            'custom-scroll',
            'modal-content'        => ! $square,
            'modal-content-square' => $square,
            $widthClass,
            $contentClass,
        ])>
            <div @class($padding)>
                @if(! $closeButtonOnly && ! $hideCross)
                    <button
                        @class([
                            'transition-default',
                            $closeButtonClass,
                        ])
                        @click="hide"
                    >
                        <x-ark-icon name="cross" size="sm" class="m-auto" />
                    </button>
                @endif

                @if ($title)
                    <h2 class="{{ $titleClass }}">
                        {{ $title }}
                    </h2>
                @endif

                {{ $description }}

                @if($buttons)
                    <div class="mt-8 text-right {{ $buttonsStyle }}">
                        {{ $buttons }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
