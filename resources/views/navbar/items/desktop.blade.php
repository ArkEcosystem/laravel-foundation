@props([
    'breakpoint'      => 'md',
    'navigation'      => [],
    'navigationExtra' => null,
    'dropdownClass'   => 'flex-shrink-0 w-56',
    'menuDropdownId'  => 'menuDropdown',
])

@php
    // Exact class strings required to prevent purging
    $breakpointClasses = [
        'sm' => 'sm:ml-6 sm:flex',
        'md' => 'md:ml-6 md:flex',
        'lg' => 'lg:ml-6 lg:flex',
        'xl' => 'xl:ml-6 xl:flex',
    ][$breakpoint];

    $extraBreakpointClasses = [
        'sm' => 'sm:flex',
        'md' => 'md:flex',
        'lg' => 'lg:flex',
        'xl' => 'xl:flex',
    ][$breakpoint];
@endphp

@if(is_array($navigation))
    <div class="hidden items-center h-full {{ $breakpointClasses }}">
        @foreach ($navigation as $navItem)
            @isset($navItem['children'])
                <div class="relative h-full">
                    <button
                        x-ref="menuDropdownButton"
                        @class([
                            'relative inline-flex justify-center items-center px-1 pt-px font-semibold leading-5 border-b-2 border-transparent text-theme-secondary-700 hover:text-theme-secondary-800 hover:border-theme-secondary-300 focus:outline-none transition duration-150 ease-in-out h-full dark:text-theme-secondary-500 dark:hover:text-theme-secondary-400',
                            'ml-8' => ! $loop->first,
                        ])
                        @click="toggleDropdown('{{ $navItem['label'] }}')"
                        @blur="closeIfBlurOutside"
                        aria-haspopup="true"
                        aria-controls="{{ $menuDropdownId }}"
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
                        x-ref="menuDropdown"
                        id="{{ $menuDropdownId }}"
                        x-show.transition.origin.top="openDropdown === '{{ $navItem['label'] }}'"
                        class="absolute top-0 left-0 z-30 py-4 mt-24 bg-white rounded-xl shadow-navbar-dropdown"
                        x-cloak
                    >
                        <div class="flex">
                            <div @class([$dropdownClass])>
                                @foreach ($navItem['children'] as $childNavItem)
                                    @include('ark::navbar.items.dropdown-item', $childNavItem)
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @php
                    $isCurrentRoute = array_key_exists('route', $navItem) && optional(Route::current())->getName() === $navItem['route'];
                @endphp
                <a
                    @if (array_key_exists('href', $navItem))
                        href="{{ $navItem['href'] }}"
                    @else
                        href="{{ route($navItem['route'], $navItem['params'] ?? []) }}"
                    @endif
                    @if (array_key_exists('attributes', $navItem))
                        @foreach($navItem['attributes'] as $attribute => $attributeValue)
                            {{ $attribute }}="{{ $attributeValue }}"
                        @endforeach
                    @endif
                    @class([
                        'inline-flex items-center px-1 pt-px font-semibold leading-5 border-b-2 space-x-3 focus:outline-none transition duration-150 ease-in-out h-full',
                        'border-theme-primary-600 text-theme-secondary-900 dark:text-theme-secondary-400 focus-visible:border-b-0 focus-visible:pt-0 focus-visible:-mt-px' => $isCurrentRoute,
                        'border-transparent text-theme-secondary-700 hover:text-theme-secondary-800 hover:border-theme-secondary-300 dark:text-theme-secondary-500 dark:hover:text-theme-secondary-400 focus-visible:rounded' => ! $isCurrentRoute,
                        'ml-8' => ! $loop->first
                    ])
                    @click="openDropdown = null;"
                    dusk='navbar-{{ Str::slug($navItem['label']) }}'
                >
                    <span>{{ $navItem['label'] }}</span>

                    @if (array_key_exists('icon', $navItem))
                        <x-ark-icon class="text-theme-primary-600" size="sm" :name="$navItem['icon']" />
                    @endif
                </a>
            @endisset
        @endforeach
    </div>

    <div @class(['hidden', $extraBreakpointClasses])>
        {{ $navigationExtra }}
    </div>
@else
    {{ $navigation }}
@endif
