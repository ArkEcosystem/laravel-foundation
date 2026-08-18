@props(['name', 'searchCategories', 'categories', 'disabled' => false])

<div class="flex h-10 w-10 items-center justify-center sm:relative">
    <x-ark-dropdown wrapper-class="inline-block items-center text-left sm:absolute"
        dropdown-classes="left-0 sm:left-auto w-auto sm:w-80" :close-on-click="false" :disabled="$disabled">
        <x-slot name="button">
            @if ($hasFilters = collect($searchCategories)->filter()->isNotEmpty())
                <span
                    class="absolute right-1 top-1 h-2 w-2 rounded-full bg-theme-danger-500 sm:right-0 sm:top-0 sm:-mr-1.5 sm:-mt-1.5"></span>
            @endif

            <x-ark-icon name="sliders-vertical" :class="Arr::toCssClasses([
                'transition-default',
                'text-theme-primary-300 hover:text-theme-primary-500' => !$disabled,
                'text-theme-secondary-500 cursor-default' => $disabled,
            ])" />
        </x-slot>

        <div class="p-10">
            <div>
                <span class="font-semibold text-theme-secondary-900">@lang('ui::pages.blog.category')</span>
                <div class="space-y-3">
                    @foreach ($categories as $k => $v)
                        <x-ark-checkbox name="pendingCategories.{{ is_string($k) ? $k : $v }}" :label="ucfirst($v)"
                            label-classes="text-base cursor-pointer" />
                    @endforeach
                </div>
            </div>
            <div class="mt-8 flex items-center justify-between border-t border-dashed border-theme-secondary-300 pt-8">
                <button type="button" class="link flex space-x-2 font-semibold"
                    wire:click.debounce.50ms="resetFilter()" @click="dropdownOpen = false">
                    <x-ark-icon name="arrows.arrow-rotate-left" />

                    <span>@lang('ui::actions.reset')</span>
                </button>
                <button type="button" class="button-secondary" wire:click.debounce.50ms="applyFilter()"
                    @click="dropdownOpen = false" @unless ($this->isDirty) disabled @endunless>
                    @lang('ui::actions.apply')
                </button>
            </div>
        </div>
    </x-ark-dropdown>
</div>
