@props([
    'options',
    'model',
    'initialValue',
    'wrapperClass' => null,
    'dropdownClass' => null,
    'width' => 'w-full mx-8 md:w-56 md:mx-0',
    'buttonClass' => null,
    'iconClass' => 'hidden',
    'mobile' => false,
])

<x-ark-rich-select :wrapper-class="Arr::toCssClasses([
    'p-2 w-full rounded-xl border md:p-0 md:w-auto md:border-0 border-theme-primary-100 dark:border-theme-secondary-800',
    $wrapperClass,
])" :dropdown-class="Arr::toCssClasses(['right-0 mt-2 origin-top-right', $dropdownClass])" :button-class="Arr::toCssClasses([
    'flex relative items-center py-4 mr-10 w-full font-semibold text-left md:inline md:items-end md:px-8 focus:outline-none text-theme-secondary-900 dark:text-theme-secondary-200',
    $buttonClass,
])" :icon-class="$iconClass" :initial-value="$initialValue"
    wire:model.live="{{ $model }}" :options="$options" :width="$width" :x-data="$mobile ? '{
    popperOptions: {
        strategy: \ 'absolute\',
        placement: \ 'bottom-start\',
        modifiers: [{
                name: \ 'preventOverflow\',
            },
            {
                name: \ 'offset\',
                options: {
                    offset: [-8, 12],
                },
            },
        ]
    },
    }
    ' : ' {}
    '"
    {{ $attributes->class('flex-1 flex justify-end') }}>
    <x-slot name="dropdownEntry">
        <div
            class="static flex w-full items-center justify-between font-semibold text-theme-secondary-500 md:justify-end md:space-x-2 md:text-theme-secondary-700">
            <div>
                <span class="text-theme-secondary-500 dark:text-theme-secondary-600">
                    @lang('ui::generic.type'):
                </span>

                <span x-text="text"
                    class="whitespace-nowrap text-theme-secondary-900 dark:text-theme-secondary-200 md:text-theme-secondary-700"></span>
            </div>

            <span
                class="absolute right-0 mr-4 flex h-6 w-6 items-center justify-center rounded-full text-theme-secondary-400 transition duration-150 ease-in-out dark:bg-theme-secondary-800 dark:text-theme-secondary-200 md:relative md:mr-0 md:h-4 md:w-4 md:bg-theme-primary-100 md:text-theme-primary-600"
                :class="{
                    'rotate-180 md:bg-theme-primary-600 md:text-theme-secondary-100': open,
                }">
                <x-ark-icon name="arrows.chevron-down-small" size="xs" class="md:h-3 md:w-2" />
            </span>
        </div>
    </x-slot>
</x-ark-rich-select>
