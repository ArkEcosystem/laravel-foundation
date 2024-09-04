<div class="{{ $class ?? ''}}" @click="Livewire.dispatch('markNotificationsAsSeen')" dusk="navigation-notifications-icon">
    <x-ark-dropdown
        wrapper-class="mx-1 md:relative"
        dropdown-classes="mt-8 md:px-0 px-8 {{ $dropdownClasses ?? '' }}"
        button-class="relative py-3 px-4 rounded transition-default group dark:text-theme-secondary-600 dark:hover:text-theme-secondary-100 dark:hover:bg-theme-secondary-800 hover:bg-theme-primary-100"
        dropdown-content-classes="bg-white border border-white dark:bg-theme-secondary-900 dark:text-theme-secondary-200 rounded-xl shadow-2xl dark:shadow-lg-dark dark:border-theme-secondary-800"
    >
        <x-slot name="button">
            <x-ark-icon name="bell" class="transition-default text-theme-secondary-600 dark:group-hover:text-theme-secondary-100 group-hover:text-theme-primary-700" />
            @isset($notificationsIndicator)
                {{ $notificationsIndicator }}
            @else
                @livewire('notifications-indicator')
            @endif
        </x-slot>

        {{ $notifications }}
    </x-ark-dropdown>
</div>
