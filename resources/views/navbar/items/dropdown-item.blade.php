@props([
    'name',
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

    <a
        @if ($disabled)
            href=""
            aria-disabled="true"
            tabindex="-1"
        @else
            href="{{ $route ? route($route, $routeParams) : $href }}"
        @endif
        @class([
            'font-semibold px-8 py-4 w-full group transition-default',
            'bg-theme-primary-50' => $isCurrent,
            'text-theme-secondary-900 hover:bg-theme-secondary-100' => ! $disabled && ! $isCurrent,
            'text-theme-secondary-500 pointer-events-none' => $disabled,
        ])
        @if ($external)
            target="_blank"
        @endif
        rel="noopener noreferrer"
        dusk='navbar-item-{{ Str::slug($name) }}'
    >
        <div
            class="flex items-center block"
            @if ($tooltip)
                data-tippy-content="{{ $tooltip }}"
            @endif
        >
            @if ($icon)
                @svg($icon, [
                    'class' => Arr::toCssClasses([
                        'mr-4 w-24 hidden lg:block',
                        'text-theme-secondary-700' => $isCurrent,
                        'text-theme-secondary-300' => ! $isCurrent,
                    ])
                ])
            @endif

            <div class="flex flex-col space-y-2 flex-1">
                <span @class([
                    'flex items-center space-x-2',
                    'text-theme-secondary-500' => $disabled,
                    'text-theme-primary-600' => ! $disabled && $isCurrent,
                    'group-hover:text-theme-primary-700' => ! $disabled && ! $isCurrent,
                ])>
                    <span>{{ $name }}</span>

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
    </a>
</div>
