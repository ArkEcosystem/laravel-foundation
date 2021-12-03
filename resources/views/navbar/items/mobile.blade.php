@props([
    'breakpoint'      => 'md',
    'navigation'      => [],
    'navigationExtra' => null,
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

<div x-cloak :class="{'block': open, 'hidden': !open}" class="border-t-2 border-theme-secondary-200 {{ $breakpointClass }}">
    <div class="pt-2 pb-4 rounded-b-lg">
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
                    <a
                        href="javascript:void(0)"
                        class="flex justify-between items-center py-3 px-8 w-full font-semibold border-l-2 border-transparent text-theme-secondary-900"
                        @click="toggleDropdown('{{ $navItem['label'] }}')"
                    >
                        <span :class="{ 'text-theme-primary-600': openDropdown === 'products' }">
                            @lang('menus.products.title')
                        </span>

                        <span
                            class="ml-2 transition duration-150 ease-in-out text-theme-primary-600"
                            :class="{ 'rotate-180': openDropdown === 'products' }"
                        >
                            <x-ark-icon name="chevron-down" size="xs" />
                        </span>
                    </a>

                    <div
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
                    :name="$navItem['label']"
                    :params="$navItem['params'] ?? []"
                    :icon="isset($navItem['icon']) ? $navItem['icon'] : false"
                />
            @endisset
        @endforeach

        {{ $navigationExtra }}
    </div>
</div>
