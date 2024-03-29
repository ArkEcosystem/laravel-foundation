@props([
    'breakpoint'                    => 'md',
    'navigation'                    => [],
    'navigationExtra'               => null,
    'mobileDropdown'                => 'mobileDropdown',
    'mobileDropdownColor'           => 'bg-white',
    'mobileDropdownBorderColor'     => 'border-theme-secondary-200',
    'mobileDropdownRounded'         => true,
    'mobileDropdownItemColor'       => null,
    'mobileDropdownActiveItemColor' => null,
])

@php
    // Exact class strings required to prevent purging
    $breakpointClass = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$breakpoint];
@endphp

<div
    @class([
        'border-t-2 w-full pointer-events-none',
        $mobilePositionClass ?? 'fixed bottom-0 top-21',
        $breakpointClass,
        $mobileDropdownBorderColor,
    ])
    :class="{
        block: open,
        hidden: !open,
    }"
    x-cloak
>
    <div @class([
        'overflow-y-auto pt-2 pb-4 max-h-full pointer-events-auto',
        $mobileDropdownColor,
        'rounded-b-lg' => $mobileDropdownRounded,
    ])>
        @if(isset($navbarNotificationsMobile) || isset($notifications))
            <div class="flex justify-center items-center py-0.5 px-2 my-4 mx-8 rounded border shadow-sm md:hidden border-theme-secondary-300">
                @isset($navbarNotificationsMobile)
                    {{ $navbarNotificationsMobile }}
                @endisset

                @if(isset($navbarNotificationsMobile) && isset($notifications))
                    <span class="mx-4 h-5 border-r border-theme-secondary-300 dark:border-theme-secondary-800"></span>
                @endif

                @isset($notifications)
                    @include('ark::navbar.notifications')
                @endisset
            </div>
        @endisset

        @foreach ($navigation as $navItem)
            @isset($navItem['children'])
                <div>
                    <button
                        class="flex justify-between items-center py-3 px-8 w-full font-semibold border-l-2 border-transparent text-theme-secondary-900"
                        @click="toggleDropdown('{{ $navItem['label'] }}')"
                        aria-haspopup="true"
                        aria-controls="{{ $mobileDropdown }}"
                        x-bind:aria-expanded="openDropdown === '{{ $navItem['label'] }}'"
                    >
                        <span :class="{ 'text-theme-primary-600': openDropdown === '{{ $navItem['label'] }}' }">
                            <span class="sr-only">
                                <span x-show="openDropdown !== '{{ $navItem['label'] }}'">
                                    @lang('ui::actions.open')
                                </span>

                                <span x-show="openDropdown === '{{ $navItem['label'] }}'">
                                    @lang('ui::actions.close')
                                </span>
                            </span>

                            {{ $navItem['label'] }}
                        </span>

                        <x-ark-chevron-toggle
                            is-open="openDropdown === '{{ $navItem['label'] }}'"
                            class="ml-2 text-theme-primary-600"
                        />
                    </button>

                    <div
                        id="{{ $mobileDropdown }}"
                        x-show="openDropdown === '{{ $navItem['label'] }}'"
                        class="mb-4 ml-8 border-l border-theme-secondary-200"
                        x-cloak
                    >
                        @foreach ($navItem['children'] as $childNavItem)
                            @include(
                                'ark::navbar.items.dropdown-item',
                                array_merge($childNavItem, ['tooltip' => null])
                            )
                        @endforeach
                    </div>
                </div>
            @else
                <x-ark-sidebar-link
                    :href="$navItem['href'] ?? null"
                    :route="$navItem['route'] ?? null"
                    :active="array_key_exists('active', $navItem) ? $navItem['active'] : null"
                    :name="$navItem['label']"
                    :params="$navItem['params'] ?? []"
                    :icon="isset($navItem['icon']) ? $navItem['icon'] : false"
                    icon-alignment="left"
                    icon-colors="text-theme-secondary-900 dark:text-theme-secondary-200 group-hover:text-theme-secondary-900"
                    active-icon-colors="text-theme-secondary-900 dark:text-theme-secondary-200"
                    :attrs="$navItem['attributes'] ?? []"
                    :rounded="false"
                    :item-class="$mobileDropdownItemColor"
                    :active-item-class="$mobileDropdownActiveItemColor"
                    x-on:click="() => {
                        closeDropdown();
                        openDropdown = null;
                    }"
                />
            @endisset
        @endforeach

        {{ $navigationExtra }}
    </div>
</div>
