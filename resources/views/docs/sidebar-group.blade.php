@props ([
    'title',
    'path',
    'first' => false,
    'borderless' => false,
])

<div
    class="px-8 lg:px-0 lg:ml-8"
    x-data="{ open: @js(Request::onDocs($path, true)) }"
    :class="{ 'last:pb-4': ! open }"
    x-cloak
>
    <button
        type="button"
        @class([
            'flex items-center justify-between w-full pr-5 py-4 border-theme-secondary-300 group',
            'border-t' => ! $borderless,
        ])
        @click.prevent="open = ! open"
    >
        <h2 class="mb-0 text-base font-semibold text-left accordion-heading text-theme-secondary-900 group-hover:text-theme-primary-600">
            {{ $title }}
        </h2>

        <span x-show="open">
            <x-ark-icon
                class="text-theme-secondary-700 group-hover:text-theme-primary-600"
                name="arrows.chevron-up-small"
                size="xs"
            />
        </span>

        <span x-show="! open">
            <x-ark-icon
                class="text-theme-secondary-700 group-hover:text-theme-primary-600"
                name="arrows.chevron-down-small"
                size="xs"
            />
        </span>
    </button>

    <div x-show="open" class="ml-1 pb-4">
        {{ $slot }}
    </div>
</div>
