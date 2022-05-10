@props([
    'options',
    'model',
    'initialValue',
    'wrapperClass'  => null,
    'dropdownClass' => null,
    'width'         => 'w-full mx-8 md:w-56 md:mx-0',
    'buttonClass'   => null,
    'iconClass'     => 'hidden',
    'mobile'        => false,
])

<x-ark-rich-select
    :wrapper-class="Arr::toCssClasses([
        'p-2 w-full rounded-xl border md:p-0 md:w-auto md:border-0 border-theme-primary-100 dark:border-theme-secondary-800',
        $wrapperClass,
    ])"
    :dropdown-class="Arr::toCssClasses([
        'right-0 mt-2 origin-top-right',
        $dropdownClass,
    ])"
    :button-class="Arr::toCssClasses([
        'flex relative items-center py-4 mr-10 w-full font-semibold text-left md:inline md:items-end md:px-8 focus:outline-none text-theme-secondary-900 dark:text-theme-secondary-200',
        $buttonClass,
    ])"
    :icon-class="$iconClass"
    :initial-value="$initialValue"
    wire:model="{{ $model }}"
    :options="$options"
    :width="$width"
    :x-data="$mobile ? '{
        popperOptions: {
            strategy: \'absolute\',
            placement: \'bottom-start\',
            modifiers: [
                {
                    name: \'preventOverflow\',
                },
                {
                    name: \'offset\',
                    options: {
                        offset: [-8, 12],
                    },
                },
            ]
        },
    }' : '{}'"
    {{ $attributes->class('flex-1 flex justify-end') }}
>
    <x-slot name="dropdownEntry">
        <div class="flex static justify-between items-center w-full font-semibold md:justify-end md:space-x-2 text-theme-secondary-500 md:text-theme-secondary-700">
            <div>
                <span class="text-theme-secondary-500 dark:text-theme-secondary-600">
                    @lang('ui::generic.type'):
                </span>

                <span
                    x-text="text"
                    class="whitespace-nowrap text-theme-secondary-900 md:text-theme-secondary-700 dark:text-theme-secondary-200"
                ></span>
            </div>

            <span
                class="flex absolute right-0 justify-center items-center mr-4 w-6 h-6 rounded-full transition duration-150 ease-in-out md:relative md:mr-0 md:w-4 md:h-4 text-theme-secondary-400 md:bg-theme-primary-100 md:text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-200"
                :class="{
                    'rotate-180 md:bg-theme-primary-600 md:text-theme-secondary-100': open,
                }"
            >
                <x-ark-icon
                    name="arrows.chevron-down-small"
                    size="xs"
                    class="md:w-2 md:h-3"
                />
            </span>
        </div>
    </x-slot>
</x-ark-rich-select>
