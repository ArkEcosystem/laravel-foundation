<div
    class="flex relative flex-col"
    x-bind:class="{
        @if ($mobileHidden) 'hidden sm:flex': mobileHidden, @endif
    }"
>
    @if($isDisabled && ! $option['checked'])
        <div data-tippy-content="{{ $disabledCheckboxTooltip }}" class="absolute inset-0"></div>
    @endif
    <label
        dusk="tile-selection-label-{{ $option['id'] }}"
        for="{{ $id.'-'.$option['id'] }}"
        @if ($single)
            tabindex="0"
            x-on:keydown.space.prevent="$event.target.querySelector('input').click()"
        @endif
        @class([
            'group',
            'tile-selection-single' => $single,
            'tile-selection-option' => ! $single,
            'disabled-tile'         => $isDisabled && ! $option['checked'],
        ])
        x-bind:class="{
            @if ($single)
                'tile-selection--checked': {{ $this->{$wireModel ?? $id} === $option['id'] ? 'true': 'false' }},
            @else
                'tile-selection--checked': {{ $option['checked'] ? 'true' : 'false' }},
            @endif
        }"
    >
        @if ($single)
            <input
                tabindex="-1"
                id="{{ $id.'-'.$option['id'] }}"
                name="{{ $id }}"
                type="radio"
                class="sr-only"
                value="{{ $option['id'] }}"
                wire:model.live="{{ $wireModel }}"
                @if($this->{$wireModel ?? $id} === $option['id'])
                    checked="checked"
                @endif
            />
        @else
            <input
                id="{{ $id.'-'.$option['id'] }}"
                name="{{ $option['id'] }}"
                type="checkbox"
                class="form-checkbox tile-selection-checkbox"
                wire:model.live="{{ $wireModel }}"
                wire:key="{{ $option['id'] }}"
                @if($isDisabled && ! $option['checked'])
                    disabled
                @endif
            />
        @endif

        <div class="{{ $iconWrapper }}">
            @unless ($withoutIcon)
                <div class="{{ $iconBreakpoints }}">
                    <x-ark-icon :name="$option['icon']" size="md" />
                </div>
            @endunless

            <div class="{{ $optionTitleClass }}">{{ $option['title'] }}</div>
        </div>
    </label>
</div>
