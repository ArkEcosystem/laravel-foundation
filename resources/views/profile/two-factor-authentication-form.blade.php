@php
    use \Illuminate\View\ComponentAttributeBag;

    $twoAuthLink1 = view('ark::external-link', [
        'attributes' => new ComponentAttributeBag([]),
        'text' => 'Authy',
        'url' => 'https://authy.com',
        'inline' => true,
    ])->render();

    $twoAuthLink2 = view('ark::external-link', [
        'attributes' => new ComponentAttributeBag([]),
        'text' => 'Google Authenticator',
        'url' => 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2',
        'inline' => true,
    ])->render();
@endphp

<div dusk="two-factor-authentication-form">
    @if (! $this->enabled)
        <div class="flex flex-col space-y-8 w-full">
            <div class="flex flex-col space-y-6 w-full sm:flex-col">
                <div class="flex flex-col">
                    <h3>
                        @lang('ui::pages.user-settings.2fa_title')
                    </h3>

                    <span class="mt-2">
                        @lang('ui::pages.user-settings.2fa_description')
                    </span>
                </div>

                <div class="flex flex-col items-center sm:flex-row sm:items-stretch sm:mt-8 sm:divide-x divide-theme-secondary-300 dark:divide-theme-secondary-800">
                    <div class="flex flex-col justify-center rounded-xl border sm:mr-8 border-theme-secondary-400 dark:border-theme-secondary-800">
                        <div class="flex flex-1 items-center py-4 px-1 md:py-2 lg:py-1 dark:bg-white">
                            {!! $this->twoFactorQrCodeSvg !!}
                        </div>

                        <div class="py-4 w-full text-center rounded-b-xl border-t border-theme-secondary-400 bg-theme-secondary-100 dark:bg-theme-secondary-800 dark:border-theme-secondary-800">
                            <span class="text-sm text-theme-secondary-900 dark:text-theme-secondary-200">
                                {{ $this->state['two_factor_secret'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col mt-8 sm:pl-8 sm:mt-0">
                        <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                            @lang('ui::pages.user-settings.2fa_not_enabled_title')
                        </span>

                        <div class="mt-4 text-base leading-7 text-theme-secondary-600">
                            @lang('ui::pages.user-settings.2fa_summary', [
                                'link1' => $twoAuthLink1,
                                'link2' => $twoAuthLink2,
                            ])
                        </div>

                        <div class="mt-6 sm:hidden md:block">
                            <x-ark-input
                                type="number"
                                name="state.otp"
                                :label="trans('ui::pages.user-settings.enter_2fa_verification_code')"
                                :errors="$errors"
                                pattern="[0-9]{6}"
                                class="hide-number-input-arrows"
                                dusk="one-time-password"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden mt-8 sm:block md:hidden">
                <x-ark-input
                    type="number"
                    name="state.otp"
                    :label="trans('ui::pages.user-settings.enter_2fa_verification_code')"
                    :errors="$errors"
                    pattern="[0-9]{6}"
                    class="hide-number-input-arrows"
                    dusk="one-time-password"
                />
            </div>

            <div class="flex pt-8 mt-8 border-t sm:justify-end sm:pt-0 sm:border-t-0 border-theme-secondary-300">
                <button
                    type="button"
                    class="w-full sm:w-auto button-secondary"
                    wire:click="enableTwoFactorAuthentication"
                    dusk="enable-two-factor-authentication"
                >
                    @lang('ui::actions.enable')
                </button>
            </div>
        </div>
    @else
        <div class="flex flex-col">
            <h4>@lang('ui::pages.user-settings.2fa_title')</h4>
            <span class="mt-4">@lang('ui::pages.user-settings.2fa_description')</span>

            <div class="flex flex-col items-center mt-4 space-y-4 sm:flex-row sm:items-start sm:mt-8 sm:space-y-0 sm:space-x-6">
                <div class="w-21 h-21">
                    <x-ark-icon name="image.2fa" class="w-21 h-21 light-dark-icon" />
                </div>

                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900 dark:text-theme-secondary-200">
                        @lang('ui::pages.user-settings.2fa_enabled_title')
                    </span>

                    <div class="mt-2 text-theme-secondary-600">

                        @lang('ui::pages.user-settings.2fa_summary', [
                            'link1' => $twoAuthLink1,
                            'link2' => $twoAuthLink2,
                        ])
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse mt-8 w-full sm:flex-row sm:justify-end sm:space-x-3">
                <button
                    type="button"
                    class="mt-4 w-full sm:mt-0 sm:w-auto button-secondary"
                    wire:click="showConfirmPassword"
                >
                    @lang('ui::actions.recovery_codes')
                </button>

                <button
                    type="submit"
                    class="w-full sm:w-auto button-primary"
                    wire:click="showDisableConfirmPassword"
                    dusk="disable-two-factor-authentication"
                >
                    @lang('ui::actions.disable')
                </button>
            </div>
        </div>
    @endif

    <div dusk="recovery-codes-modal">
        @if($this->modalShown)
            <x:ark-fortify::modals.2fa-recovery-codes />
        @endif
    </div>

    @if($this->confirmPasswordShown)
        <x:ark-fortify::modals.password-confirmation
            :title="trans('ui::forms.confirm-password.title')"
            :description="trans('ui::forms.confirm-password.description')"
            action-method="showRecoveryCodesAfterPasswordConfirmation"
            close-method="closeConfirmPassword"
        />
    @endif

    @if($this->disableConfirmPasswordShown)
        <x:ark-fortify::modals.password-confirmation
            :title="trans('ui::forms.disable-2fa.title')"
            :description="trans('ui::forms.disable-2fa.description')"
            action-method="disableTwoFactorAuthentication"
            close-method="closeDisableConfirmPassword"
        />
    @endif
</div>
