<div
    x-data="{isTyping: false}"
    @updated-password.window="isTyping = false"
    dusk="update-password-form"
>
    <div class="flex flex-col mt-8 space-y-4">
        @if (flash()->message)
            <div>
                <x-ark-flash />
            </div>
        @endif

        <h3>
            @lang('ui::pages.user-settings.password_information_title')
        </h3>

        <span>
            @lang('ui::forms.update-password.requirements_notice')
        </span>
    </div>

    <form class="mt-8" wire:submit.prevent="updatePassword">
        <div class="space-y-4">
            <input type="hidden" autocomplete="email" />

            <x-ark-password-toggle
                name="current_password"
                model="currentPassword"
                :label="trans('ui::forms.current_password')"
                :errors="$errors"
                class="w-full"
                autocomplete="current-password"
            />

            <x:ark-fortify::password-rules
                class="w-full"
                :password-rules="$passwordRules"
                is-typing="isTyping"
                rules-wrapper-class="grid gap-4 my-4 sm:grid-cols-2 lg:grid-cols-3"
                @typing="isTyping=true"
            >
                <x-ark-password-toggle
                    name="password"
                    model="password"
                    class="w-full"
                    :label="trans('ui::forms.new_password')"
                    :errors="$errors"
                    @keydown="isTyping=true"
                    autocomplete="new-password"
                />
            </x:ark-fortify::password-rules>

            <x-ark-password-toggle
                name="password_confirmation"
                model="password_confirmation"
                :label="trans('ui::forms.confirm_password')"
                :errors="$errors"
                autocomplete="new-password"
            />
        </div>

        <div class="flex mt-8 w-full sm:justify-end">
            <button
                dusk="update-password-form-submit"
                type="submit"
                class="w-full sm:w-auto button-secondary"
            >
                @lang('ui::actions.update')
            </button>
        </div>
    </form>
</div>
