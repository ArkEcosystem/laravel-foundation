@props ([
    'name',
])

<div
    x-data="{
        searchOpen: false,
        init() {
            this.$watch('searchOpen', (searchOpen) => {
                if (searchOpen) {
                    this.$nextTick(() => {
                        this.$refs.searchInput.focus();
                    });
                }
            });
        }
    }"
    class="flex items-center sm:relative"
    @click="searchOpen = true"
    @click.outside="searchOpen = false"
>
    <div class="flex items-center space-x-2 font-semibold cursor-pointer text-theme-primary-300 transition-default hover:text-theme-primary-500">
        <span class="text-sm">
            @lang('general.search')
        </span>
        <x-ark-icon name="magnifying-glass" />
    </div>
    <div
        x-show="searchOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="flex absolute right-0 left-0 bottom-5 z-30 items-center p-8 -mr-1 space-x-3 w-full bg-white rounded-lg shadow-lg origin-bottom-right sm:bottom-0 sm:left-auto sm:mr-12 sm:w-search"
        x-cloak
    >
        <input
            x-ref="searchInput"
            type="text"
            placeholder="Search"
            class="w-full"
            maxlength="30"
            wire:model.debounce.500ms="{{ $name }}"
        />
        <x-ark-icon name="magnifying-glass" class="text-theme-secondary-500" />
    </div>
</div>
