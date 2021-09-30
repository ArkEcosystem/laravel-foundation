<x:ark-fortify::form-wrapper x-show="!recovery"
                             action="{{ isset($resetPassword)
                                    ? route('two-factor.reset-password-store', ['token' => $token])
                                    : route('two-factor.login') }}">
    <div class="mb-8">
        @isset($resetPassword)
            <input type="hidden" name="email" value="{{ $email }}"/>
        @endisset

        <div class="flex flex-1">
            <x-ark-input
                type="text"
                name="code"
                :label="trans('ui::forms.2fa_code')"
                class="w-full hide-number-input-arrows"
                :errors="$errors"
                autocomplete="one-time-code"
                input-mode="numeric"
                pattern="[0-9]{6}"
            />
        </div>
    </div>

    <div class="flex flex-col-reverse justify-between items-center sm:flex-row">
        <button @click="recovery = true" type="button" class="mt-4 w-full font-semibold sm:mt-0 sm:w-auto link">
            @lang('ui::actions.enter_recovery_code')
        </button>

        <button type="submit" class="w-full sm:w-auto button-secondary">
            @lang('ui::actions.sign_in')
        </button>
    </div>
</x:ark-fortify::form-wrapper>
