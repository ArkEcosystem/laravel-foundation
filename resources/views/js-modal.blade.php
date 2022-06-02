@props([
    'init' => false,
    'xData' => '{}',
    'class' => '',
    'widthClass' => 'max-w-2xl',
    'title' => null,
    'titleClass' => 'inline-block pb-3 font-bold dark:text-theme-secondary-200',
    'buttons' => null,
    'buttonsStyle' => 'modal-buttons',
    'closeButtonOnly' => false,
    'escToClose' => true,
    'name' => '',
])

<div
    {{ $attributes }}
    x-ref="modal"
    data-modal="{{ $name }}"
    x-cloak
    @if($init)
    x-data="Modal.alpine({{ $xData }}, '{{ $name }}')"
    @else
    x-data="{{ $xData }}"
    @endif
    @if(!$closeButtonOnly && $escToClose)
    @keydown.escape="hide"
    tabindex="0"
    @endif
    x-show="shown"
    class="flex overflow-y-auto fixed inset-0 z-50 md:py-10 md:px-8"
>

    <div class="fixed inset-0 opacity-75 dark:opacity-50 bg-theme-secondary-900 dark:bg-theme-secondary-800"></div>

    <div
        class="modal-content-wrapper md:m-auto w-full {{ $class }} {{ $widthClass }}"
        @if(!$closeButtonOnly)
        @click.outside="hide"
        @endif
    >
        <div class="modal-content custom-scroll {{ $widthClass }}">
            <div class="p-8 sm:p-10">
                @if(!$closeButtonOnly)
                <button
                    class="modal-close"
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
