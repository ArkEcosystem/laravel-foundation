<div>
    <div class="flex flex-col">
        <span class="header-4">@lang('ui::pages.user-settings.delete_account_title')</span>
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
                <div class="flex flex-col mt-4">
                    <div class="flex justify-center w-full">
                        <x-ark-icon name="fortify-modal.delete-account" class="w-2/3 h-auto text-theme-primary-600"/>
                    </div>
                    <div class="mt-4">
                        @if(trans()->has('forms.delete-user.confirmation'))
                            @lang('forms.delete-user.confirmation')
                        @else
                            @lang('ui::forms.delete-user.confirmation', ['appName' => config('app.name')])
                        @endunless
                    </div>
                </div>
                <form class="mt-8">
                    <div class="space-y-2">
                        <x-ark-input
                            type="password"
                            name="confirmedPassword"
                            model="confirmedPassword"
                            :label="trans('ui::forms.your_password')"
                        />
                    </div>
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
                </form>
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
