@props([
    'label',
    'description' => null,
    'route'       => null,
    'href'        => null,
    'routeParams' => [],
    'icon'        => null,
    'disabled'    => false,
    'external'    => false,
    'tooltip'     => null,
])

@php ($isCurrent = $disabled === false && $route && url()->full() === route($route, $routeParams))

<div class="flex">
    <div @class([
        'w-1 -mr-1 z-10',
        'bg-theme-primary-600' => $isCurrent,
    ])></div>

    @unless ($disabled)
        <a
            href="{{ $route ? route($route, $routeParams) : $href }}"
            @class([
                'font-semibold px-8 py-4 w-full group transition-default',
                'bg-theme-primary-50' => $isCurrent,
                'text-theme-secondary-900 hover:bg-theme-secondary-100' => ! $disabled && ! $isCurrent,
            ])
            @if ($external)
                target="_blank"
                rel="noopener noreferrer"
            @endif
            dusk="navbar-item-{{ Str::slug($label) }}"
        >
    @else
        <div
            class="py-4 px-8 w-full font-semibold cursor-default text-theme-secondary-500"
            dusk="navbar-item-{{ Str::slug($label) }}"
        >
    @endunless
        <div
            class="block flex items-center"
            @if ($tooltip)
                data-tippy-content="{{ $tooltip }}"
            @endif
        >
            @if ($icon)
                <x-ark-icon :name="$icon" :class="Arr::toCssClasses([
                    'mr-4 w-24 hidden lg:block',
                    'text-theme-secondary-700' => $isCurrent,
                    'text-theme-secondary-300' => ! $isCurrent,
                ])" />
            @endif

            <div class="flex flex-col flex-1 space-y-2">
                <span @class([
                    'flex items-center space-x-2 transition-default',
                    'text-theme-secondary-500' => $disabled,
                    'text-theme-primary-600' => ! $disabled && $isCurrent,
                    'group-hover:text-theme-primary-700' => ! $disabled && ! $isCurrent,
                ])>
                    <span>{{ $label }}</span>

                    @if ($external)
                        <x-ark-icon
                            name="link"
                            size="sm"
                            class="text-theme-primary-500"
                        />
                    @endif
                </span>

                @if ($description)
                    <span @class([
                        'text-xs hidden md:block',
                        'text-theme-secondary-500' => ! $isCurrent || $disabled,
                        'text-theme-secondary-700' => ! $disabled && $isCurrent,
                    ])>
                        {{ $description }}
                    </span>
                @endif
            </div>
        </div>
    @unless ($disabled)
        </a>
    @else
        </div>
    @endunless
</div>
