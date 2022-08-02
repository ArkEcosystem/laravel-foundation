@props ([
    'name',
    'disabled' => false
])

<div
    class="flex items-center md:relative"
    @unless ($disabled)
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
        @click="searchOpen = true"
        @click.outside="searchOpen = false"
    @endunless
>
    <div
        @class([
            "flex items-center space-x-2 font-semibold",
            "transition-default hover:text-theme-primary-500 text-theme-primary-300 cursor-pointer" => ! $disabled,
            "text-theme-secondary-500" => $disabled,
        ])
    >
        <span class="text-sm">
            @lang('ui::pages.blog.search')
        </span>
        <x-ark-icon name="magnifying-glass" />
    </div>
    @unless ($disabled)
    <div
        x-show="searchOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="flex absolute right-0 left-0 bottom-5 z-30 items-center p-8 -mr-1 space-x-3 w-full bg-white rounded-lg shadow-lg origin-bottom-right sm:bottom-0 sm:left-auto sm:mr-12 sm:w-136"
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
    @endunless
</div>
