@props([
    'disabled' => false
])

<div class="flex space-x-2 text-sm font-medium">
    <span class="leading-none text-theme-secondary-900">
        @lang('general.sort_by'):
    </span>

    <div class="flex items-center divide-x divide-theme-primary-100">
        <span
            @class([
                "flex items-center px-2 space-x-1",
                "cursor-pointer" => !$disabled,
                "text-theme-secondary-500" => $disabled,
            ])
            @unless ($disabled)
                wire:click="sort"
            @endunless
        >
            <span class="leading-none">
                @lang('general.date')
            </span>

            @if($this->sortDirection === 'asc')
                <x-ark-icon name="arrows.chevron-up-small" size="xs" />
            @else
                <x-ark-icon name="arrows.chevron-down-small" size="xs" />
            @endif
        </span>
    </div>
</div>
