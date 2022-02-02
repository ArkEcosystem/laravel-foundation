<div>
    <div class="flex flex-col">
        <h3>@lang('ui::pages.user-settings.delete_account_title')</h3>
        <span class="mt-4">
            @lang('ui::pages.user-settings.delete_account_description')
        </span>

        <div class="flex flex-row justify-end mt-8">
            <button type="submit" class="inline-flex justify-center items-center space-x-2 w-full sm:w-auto button-cancel"
                wire:click="confirmUserDeletion">
                <x-ark-icon name="trash" size="sm" />
                <span>@lang('ui::actions.delete_account')</span>
            </button>
        </div>
    </div>

    @if($this->modalShown)
        <x-ark-modal title-class="header-2" width-class="max-w-xl" wire-close="closeModal">
            <x-slot name="title">
                @lang('ui::forms.delete-user.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex flex-col">
                    <div class="flex justify-center w-full">
                        <x-ark-icon :name="$icon ?? 'fortify-modal.delete-account'" class="mt-8 mb-4 w-60 h-auto text-theme-primary-600 light-dark-icon"/>
                    </div>

                    @if($alert)
                        <div class="mt-4">
                            <x-ark-alert :type="$alertType" class="py-4 mx-auto">
                                {!! $alert !!}
                            </x-ark-alert>
                        </div>
                    @endif

                    @if($showConfirmationMessage)
                    <div class="mt-4">
                        @lang('ui::forms.delete-user.confirmation')
                    </div>
                    @endif
                </div>

                @if($confirmPassword)
                <div class="space-y-2">
                    <x-ark-input
                        type="password"
                        name="confirmedPassword"
                        model="confirmedPassword"
                        :label="trans('ui::forms.your_password')"
                    />
                </div>
                @elseif($confirmUsername)
                <div class="flex flex-col mt-4">
                    <span class="input-label">Username</span>
                    <div class="mb-2 input-wrapper">
                        <input type="text" value="{{ $this->user->name }}" class="font-semibold text-center input-text" readonly/>
                    </div>
                    <x-ark-input name="confirmedUsername" model="confirmedUsername" label=" " :placeholder="trans('modals.delete-user.input_placeholder')"></x-ark-input>
                </div>
                @endif

                <div class="mt-4">
                    <x-ark-textarea
                        name="feedback"
                        model="feedback"
                        :label="trans('ui::forms.feedback.label')"
                        :placeholder="trans('ui::forms.feedback.placeholder')"
                        :auxiliary-title="trans('ui::forms.optional')"
                        rows="5"
                    />
                </div>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col justify-end w-full sm:flex-row sm:space-x-3">
                    <button type="button" dusk="delete-user-form-cancel" class="mb-4 sm:mb-0 button-secondary" wire:click="closeModal">
                        @lang('ui::actions.cancel')
                    </button>

                    <button
                        wire:click="deleteUser"
                        type="button"
                        dusk="delete-user-form-submit"
                        class="inline-flex justify-center items-center button-cancel"
                        @unless($this->getErrorBag()->isEmpty()) disabled @endunless
                    >
                        <x-ark-icon name="trash" size="sm"/>
                        <span class="ml-2">@lang('ui::actions.delete')</span>
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>
