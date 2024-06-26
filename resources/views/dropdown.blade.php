@props([
    'dropdownProperty'       => 'dropdownOpen',
    'dropdownContentClasses' => 'bg-white rounded-xl shadow-lg dark:bg-theme-secondary-800 dark:text-theme-secondary-200',
    'buttonClassExpanded'    => 'text-theme-primary-500',
    'buttonClassClosed'      => '',
    'buttonClass'            => 'text-theme-secondary-400 hover:text-theme-primary-500',
    'dropdownClasses'        => 'w-40',
    'zIndex'                 => 'z-10',
    'dropdownOriginClass'    => 'origin-top-right',
    'wrapperClass'           => 'absolute inline-block top-0 right-0 text-left',
    'fullScreen'             => false,
    'dusk'                   => false,
    'buttonTooltip'          => null,
    'height'                 => null,
    'initAlpine'             => true,
    'closeOnBlur'            => true,
    'onClose'                => null,
    'disabled'               => false,
    'withPlacement'          => false,
    'withoutButton'          => false,
    'placementFallbacks'     => null,
    'contentClass'           => 'py-1',
])

<div
    @if ($withPlacement)
        x-data="Dropdown.setup('{{ $dropdownProperty }}', {
            @if($onClose)
                onClosed: ({{ $onClose }}),
            @endif
            placement: '{{ $withPlacement }}',
            @if ($placementFallbacks)
                placementFallbacks: {{ json_encode($placementFallbacks) }},
            @endif
        })"
        x-init="init"
    @elseif ($initAlpine)
        x-data="{ {{ $dropdownProperty }}: false }"
        x-init="$watch('{{ $dropdownProperty }}', (expanded) => {
            if (expanded) {
                $nextTick(() => {
                    $el.querySelectorAll('img[onload]').forEach(img => {
                        if (img.onload) {
                            img.onload();
                            img.removeAttribute('onload');
                        }
                    });
                })
            @if($onClose)
            } else {
                $nextTick(() => {
                    ({{ $onClose }})($el);
                });
            @endif
            }
        })"
    @endif
    @if($closeOnBlur)
        @keydown.escape="{{ $dropdownProperty }} = false"
        @click.outside="{{ $dropdownProperty }} = false"
    @endif
    @if($wrapperClass) class="{{ $wrapperClass }}" @endif
    @if($dusk) dusk="{{ $dusk }}" @endif
>
    @unless($withoutButton)
        <div>
            <button
                type="button"
                :class="{ '{{ $buttonClassExpanded }}' : {{ $dropdownProperty }}, '{{ $buttonClassClosed }}' : !{{ $dropdownProperty }} }"
                class="flex items-center focus:outline-none dropdown-button transition-default {{ $buttonClass }}"
                @if($disabled) disabled @else @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}" @endif
                @if($buttonTooltip) data-tippy-content="{{ $buttonTooltip }}" @endif
            >
                @if($button ?? false)
                    {{ $button }}
                @else
                    <x-ark-icon name="ellipsis-vertical" />
                @endif
            </button>
        </div>
    @endunless

    <div
        x-show="{{ $dropdownProperty }}"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @class([
            'absolute right-0 mt-2 dropdown',
            $dropdownClasses,
            $zIndex,
            'w-screen -mx-8 md:w-auto md:mx-0' => $fullScreen,
        ])
        @if ($height) data-height="{{ $height }}" @endif
    >
        <div class="{{ $dropdownContentClasses }}" x-cloak>
            <div
                @class($contentClass)

                @if($closeOnClick ?? true)
                    @click="{{ $dropdownProperty }} = !{{ $dropdownProperty }}"
                @endif
            >
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
