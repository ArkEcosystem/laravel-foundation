@props([
    'actionMethod',
    'closeMethod',
    'title',
    'description',
    'image' => null,
    'icon'  => 'modal.confirm-password',
])

<x-ark-modal
    title-class="header-2"
    width-class="max-w-xl"
    :wire-close="$closeMethod"
>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="description">
        <div class="flex flex-col">
            <div class="flex justify-center mt-8 w-full">
                @if ($image)
                    <img
                        src="{{ asset($image) }}"
                        class="h-28"
                        alt=""
                    />
                @elseif ($icon)
                    <x-ark-icon :name="$icon" class="h-28 light-dark-icon" />
                @endif
            </div>

            <div class="mt-8">
                {{ $description }}
            </div>
        </div>

        <form
            id="password-confirmation"
            class="mt-8"
            @keydown.enter="$wire.{{ $actionMethod }}()"
            x-on:submit.prevent
        >
            <div class="space-y-2">
                <input
                    type="hidden"
                    autocomplete="email"
                />

                <x-ark-password-toggle
                    name="confirmedPassword"
                    :label="trans('ui::forms.password')"
                    :errors="$errors"
                />
            </div>
        </form>
    </x-slot>

    <x-slot name="buttons">
        <div class="flex flex-col-reverse justify-end space-y-4 space-y-reverse w-full sm:flex-row sm:space-y-0 sm:space-x-3">
            <button
                type="button"
                dusk="confirm-password-form-cancel"
                class="button-secondary"
                wire:click="{{ $closeMethod }}"
            >
                @lang('ui::actions.cancel')
            </button>

            <button
                type="submit"
                form="password-confirmation"
                dusk="confirm-password-form-submit"
                class="inline-flex justify-center items-center button-primary"
                wire:click="{{ $actionMethod }}"
            >
                @lang('ui::actions.confirm')
            </button>
        </div>
    </x-slot>
</x-ark-modal>
