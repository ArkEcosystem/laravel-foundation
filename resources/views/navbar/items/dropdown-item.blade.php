@props([
    'label',
    'rawLabel'              => false,
    'description'           => null,
    'route'                 => null,
    'href'                  => null,
    'routeParams'           => [],
    'icon'                  => null,
    'active'                => null,
    'mobileIcon'            => null,
    'iconWidth'             => 'w-24',
    'iconBreakpoint'        => 'lg',
    'disabled'              => false,
    'external'              => false,
    'hideExternalIcon'      => false,
    'tooltip'               => null,
    'hoverClass'            => 'hover:bg-theme-secondary-100',
    'textHoverColor'        => 'group-hover:text-theme-primary-700',
    'descriptionHoverColor' => null,
])

@php
    $isCurrent = $disabled === false && $route && url()->full() === route($route, $routeParams);

    if ($active !== null) {
        $isCurrent = $active;
    }

    $mainIconBreakpoint = [
        'sm' => 'sm:block',
        'md' => 'md:block',
        'lg' => 'lg:block',
        'xl' => 'xl:block',
    ][$iconBreakpoint ?? 'lg'];

    $mobileIconBreakpoint = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$iconBreakpoint ?? 'md'];
@endphp


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
                'text-theme-secondary-900' => ! $disabled && ! $isCurrent,
                $hoverClass => ! $disabled && ! $isCurrent,
            ])
            @if ($external)
                target="_blank"
                rel="noopener noreferrer"
            @endif
            x-on:click="() => {
                closeDropdown();
                openDropdown = null;
            }"
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
            @if ($mobileIcon)
                <x-ark-icon :name="$mobileIcon" :class="Arr::toCssClasses([
                    $iconWidth,
                    $mobileIconBreakpoint,
                    'mr-4 h-auto block',
                    'text-theme-secondary-700' => $isCurrent,
                    'text-theme-secondary-300' => ! $isCurrent,
                ])" />
            @endif

            @if ($icon)
                <x-ark-icon :name="$icon" :class="Arr::toCssClasses([
                    $iconWidth,
                    $mainIconBreakpoint,
                    'mr-4 h-auto hidden',
                    'text-theme-secondary-700' => $isCurrent,
                    'text-theme-secondary-300' => ! $isCurrent,
                ])" />
            @endif

            <div class="flex flex-col flex-1 space-y-2">
                <span @class([
                    'flex items-center space-x-2 transition-default',
                    'text-theme-secondary-500' => $disabled,
                    'text-theme-primary-600' => ! $disabled && $isCurrent,
                    $textHoverColor => ! $disabled && ! $isCurrent,
                ])>
                    @if ($rawLabel)
                        <span>{!! $label !!}</span>
                    @else
                        <span>{{ $label }}</span>
                    @endif

                    @if ($external && ! $hideExternalIcon)
                        <x-ark-icon
                            name="arrows.arrow-external"
                            size="sm"
                            class="text-theme-primary-500"
                        />
                    @endif
                </span>

                @if ($description)
                    <span @class([
                        'text-xs hidden md:block transition-default',
                        'text-theme-secondary-500' => ! $isCurrent || $disabled,
                        'text-theme-secondary-700' => ! $disabled && $isCurrent,
                        $descriptionHoverColor => ! $disabled && ! $isCurrent,
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
