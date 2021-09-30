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
            <div class="flex flex-col">
                <span class="header-4">
                    @lang('ui::pages.user-settings.2fa_title')
                </span>
                <span class="mt-4">
                    @lang('ui::pages.user-settings.2fa_description')
                </span>
            </div>

            <div class="flex flex-col sm:hidden">
                <span class="header-4">
                    @lang('ui::pages.user-settings.2fa_not_enabled_title')
                </span>
                <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                    @lang('ui::pages.user-settings.2fa_summary', [
                        'link1' => $twoAuthLink1,
                        'link2' => $twoAuthLink2,
                    ])
                </div>
            </div>

            <div class="flex mt-8 space-y-4 w-full sm:hidden">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('ui::pages.user-settings.one_time_password')"
                        :errors="$errors"
                        pattern="[0-9]{6}"
                        class="hide-number-input-arrows"
                    />
                </div>
            </div>

            <hr class="flex my-8 border-t sm:hidden border-theme-primary-100">

            <div class="flex flex-col items-center sm:flex-row sm:items-start sm:mt-8">
                <div class="flex flex-col justify-center items-center rounded-xl border sm:mr-10 border-theme-secondary-400">
                    <div class="py-2 px-2">
                        {!! $this->twoFactorQrCodeSvg !!}
                    </div>
                    <div class="py-2 mt-1 w-full text-center rounded-b-xl border-t border-theme-secondary-400 bg-theme-secondary-100">
                        <span class="text-theme-secondary-900">{{ $this->state['two_factor_secret'] }}</span>
                    </div>
                </div>

                <div class="hidden mr-10 w-1 h-64 sm:flex bg-theme-primary-100"></div>

                <div class="hidden flex-col sm:flex">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
                        @lang('ui::pages.user-settings.2fa_not_enabled_title')
                    </span>


                    <div class="mt-2 text-base leading-7 text-theme-secondary-600">
                        @lang('ui::pages.user-settings.2fa_summary', [
                            'link1' => $twoAuthLink1,
                            'link2' => $twoAuthLink2,
                        ])
                    </div>

                    <div class="hidden mt-8 w-full md:flex">
                        <div class="w-full">
                            <x-ark-input
                                type="number"
                                name="state.otp"
                                :label="trans('ui::pages.user-settings.one_time_password')"
                                :errors="$errors"
                                pattern="[0-9]{6}"
                                class="hide-number-input-arrows"
                                dusk="one-time-password"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden mt-8 space-y-4 w-full sm:flex md:hidden">
                <div class="w-full">
                    <x-ark-input
                        type="number"
                        name="state.otp"
                        :label="trans('ui::pages.user-settings.one_time_password')"
                        :errors="$errors"
                        pattern="[0-9]{6}"
                        class="hide-number-input-arrows"
                    />
                </div>
            </div>

            <div class="flex mt-8 sm:justify-end">
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
            <span class="header-4">@lang('ui::pages.user-settings.2fa_title')</span>
            <span class="mt-4">@lang('ui::pages.user-settings.2fa_description')</span>

            <div class="flex flex-col items-center mt-4 space-y-4 sm:flex-row sm:items-start sm:mt-8 sm:space-y-0 sm:space-x-6">
                <img src="{{ asset('/images/profile/2fa.svg') }}" class="w-24 h-24" alt="">
                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-7 text-theme-secondary-900">
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

            <div class="flex flex-col mt-8 space-y-3 w-full sm:flex-row sm:justify-end sm:space-y-0 sm:space-x-3">
                <button type="button" class="w-full sm:w-auto button-secondary" wire:click="showConfirmPassword">
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
