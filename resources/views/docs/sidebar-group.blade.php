@props ([
    'title',
    'path',
    'first' => false,
    'borderless' => false,
])

<div
    class="lg:ml-8"
    x-data="{ open: @js(Request::onDocs($path)) }"
    :class="{ 'last:pb-4': ! open }"
    x-cloak
>
    <button
        type="button"
        @class([
            'flex items-center justify-between w-full pl-5 lg:pl-0 pr-5 border-theme-secondary-300 group',
            'pt-4 lg:mt-4 lg:border-t' => $first && ! $borderless,
            'pt-4 mt-4 border-t' => ! $first && ! $borderless,
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

    <div x-show="open" class="mt-4">
        {{ $slot }}
    </div>
</div>
