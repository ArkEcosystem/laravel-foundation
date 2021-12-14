<div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="inline-block relative w-full text-left">
    <div>
        <button
            @click="open = !open"
            type="button"
            class="inline-flex relative justify-start items-center py-3 px-4 w-full rounded border border-theme-secondary-200 dark:border-theme-secondary-800"
        >
            <x-ark-icon name="menu-open" size="sm" class="mr-3 text-theme-secondary-900 dark:text-theme-secondary-200" />
            <span class="font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">{{ $title }}</span>
        </button>
    </div>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 z-10 mt-2 w-full max-w-full rounded-md shadow-lg origin-top"
        x-cloak
    >
        <div class="w-full py-4 bg-white rounded-md shadow-lg dark:bg-theme-secondary-800 {{ $navigationClass ?? '' }}">
            {{ $navigation }}
        </div>
    </div>
</div>
