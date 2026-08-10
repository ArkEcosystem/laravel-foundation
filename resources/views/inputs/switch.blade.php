<div x-data="{
    value: {{ $default ?? 'false' }},
    toggle() {
        this.value = !this.value;
        this.$refs['checkbox-livewire'].click();
    },
    focused: false
}" class="flex items-center space-x-3">
    <span class="{{ $labelClass ?? '' }} font-semibold" :class="{ 'text-theme-secondary-500': !value }">
        {{ $leftLabel }}
    </span>

    <span @focus="focused = true" @blur="focused = false"
        class="relative inline-flex h-5 w-8 flex-shrink-0 cursor-pointer items-center justify-center focus:outline-none focus-visible:rounded focus-visible:ring-2 focus-visible:ring-theme-primary-500"
        role="checkbox" tabindex="0" @click="toggle()" @keydown.space.prevent="toggle()" :aria-checked="value.toString()">
        <span aria-hidden="true"
            class="absolute mx-auto h-1.5 w-full rounded-full bg-theme-secondary-300 transition-colors duration-200 ease-in-out dark:bg-theme-secondary-800"></span>
        <span aria-hidden="true"
            :class="{
                'input-switch-button-left': !value,
                'input-switch-button-right': value
            }"
            class="absolute left-0 inline-block h-4 w-4 transform cursor-pointer rounded-full bg-white transition duration-200 ease-in-out"></span>
    </span>
    <input x-ref="checkbox-livewire" type="checkbox" name="{{ $name }}" class="hidden"
        wire:model.live="{{ $model ?? $name }}"
        @if ($alpineClick ?? false) x-on:click="{{ $alpineClick }}" @endif
        @if ($default ?? false) checked @endif />

    <span class="{{ $labelClass ?? '' }} font-semibold" :class="{ 'text-theme-secondary-500': value }">
        {{ $rightLabel }}
    </span>
</div>
