@php($showDarkMode = config('ui.dark-mode.enabled') === true && ($profileMenuDarkMode ?? false))

<x-ark-dropdown
    wrapper-class="whitespace-nowrap md:relative"
    :dropdown-classes="Arr::toCssClasses([
        'w-full md:w-auto mt-4',
        'min-w-63' => $showDarkMode,
        $profileMenuClass ?? null,
    ])"
    dropdown-content-classes="bg-white rounded-xl shadow-lg dark:bg-theme-secondary-800 dark:text-theme-secondary-200 py-4"
    button-class="overflow-hidden rounded-xl border-2 border-transparent hover:border-theme-primary-600"
    dusk="navbar-profile-dropdown"
>
    <x-slot name="button">
        <span class="inline-block relative avatar-wrapper">
            @isset($identifier)
                <x-ark-avatar
                    :identifier="$identifier"
                    :show-identifier-letters="$showIdentifierLetters ?? false"
                    class="-m-1 w-12 h-12 rounded-xl md:h-13 md:w-13"
                    x-bind:class="{ 'border-theme-primary-600': dropdownOpen }"
                />
            @else
                <div class="overflow-hidden w-10 h-10 rounded-xl border-2 border-transparent md:w-11 md:h-11">
                    {{ $profilePhoto->img('', ['class' => 'object-cover w-full h-full', 'alt' => trans('ui::general.profile_avatar_alt')]) }}
                </div>
            @endisset
        </span>
    </x-slot>

    @foreach ($profileMenu as $menuItem)
        @if($menuItem['hasDivider'] ?? false)
            <div class="mx-8">
                <x-ark-divider />
            </div>
        @endif

        @if ($menuItem['isPost'] ?? false)
            <form method="POST" action="{{ route($menuItem['route']) }}">
                @csrf

                <button
                    type="submit"
                    class="focus-visible:rounded focus-visible:ring-inset dropdown-entry"
                    dusk="dropdown-entry-{{ Str::slug($menuItem['label']) }}"
                >
                    <div class="flex items-center space-x-3">
                        @if($menuItem['icon'] ?? false)
                            <x-ark-icon :name="$menuItem['icon']" class="inline" />
                        @endif

                        <span class="flex-1">{{ $menuItem['label'] }}</span>
                    </div>
                </button>
            </form>
        @else
            <a
                @isset($menuItem['href'])
                    href="{{ $menuItem['href'] }}"
                @else
                    href="{{ route($menuItem['route']) }}"
                @endif
                class="focus-visible:rounded focus-visible:ring-inset dropdown-entry"
                dusk="dropdown-entry-{{ Str::slug($menuItem['label']) }}"
                @foreach(Arr::get($menuItem, 'attributes', []) as $attribute => $attributeValue)
                    {{ $attribute }}="{{ $attributeValue }}"
                @endforeach
            >
                <div class="flex items-center space-x-3">
                    @if($menuItem['icon'] ?? false)
                        <x-ark-icon :name="$menuItem['icon']" calss="inline" />
                    @endif

                    <span class="flex-1">{{ $menuItem['label'] }}</span>
                </div>
            </a>
        @endif
    @endforeach

    @if ($showDarkMode)
        <div class="my-4 mx-8">
            <x-ark-divider color-class="bg-theme-secondary-300 text-theme-secondary-300 dark:bg-theme-secondary-700" />
        </div>

        <div
            class="flex justify-between items-center mx-8 mt-8 mb-4"
            @click.stop
        >
            <div class="flex items-center space-x-2 font-medium cursor-default text-theme-secondary-900 dark:text-theme-secondary-200">
                <x-ark-icon name="moon-underline" />

                <span>@lang('ui::actions.dark_theme')</span>
            </div>

            <x-ark-toggle
                name="darkTheme"
                default="window.getThemeMode() === 'dark'"
                alpine-click="Livewire.dispatch('settings.set-dark-mode', {darkMode: value})"
                no-model
                hide-label
                backdrop-color="bg-theme-secondary-300 dark:bg-theme-secondary-700"
            />
        </div>
    @endif
</x-ark-dropdown>
