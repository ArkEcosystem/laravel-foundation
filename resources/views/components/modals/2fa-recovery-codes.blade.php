<x-ark-modal title-class="header-2">
    @slot('title')
        @lang('ui::pages.user-settings.2fa_reset_code_title')
    @endslot

    @slot('description')
        <div class="mt-8 flex flex-col space-y-4">
            <x-ark-alert type="warning">
                @lang('ui::pages.user-settings.2fa_warning_text')
            </x-ark-alert>
            <div class="grid grid-flow-row grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                    <x-ark-input-with-prefix name="resetCode_{{ $loop->index }}" :value="$code"
                        input-class="cursor-default" hide-label no-model readonly>
                        <x-slot name="prefix">
                            <span class="dark:text-theme-secondary-200">
                                {{ $loop->index + 1 }}
                            </span>
                        </x-slot>
                    </x-ark-input-with-prefix>
                @endforeach
                {{-- TODO: check if we need this or not --}}
                {{-- <div class="mt-6">
                    <x-ark-clipboard :value="$this->resetCode"/>
                </div> --}}
            </div>
        </div>
    @endslot

    @slot('buttons')
        <div class="flex w-full flex-col-reverse sm:flex-row sm:justify-between">
            <div class="mt-3 flex w-full justify-center sm:mt-0 sm:justify-start">
                <x-ark-file-download :filename="'2fa_recovery_code_' . $this->user->name" :content="implode('\n', json_decode(decrypt($this->user->two_factor_recovery_codes)))" :title="trans('ui::actions.download')" wrapper-class="w-full sm:w-auto"
                    class="w-full justify-center" />
            </div>
            <div class="flex justify-center">
                <button type="button" class="button-primary w-full items-center whitespace-nowrap sm:w-auto"
                    wire:click="hideRecoveryCodes" dusk="recovery-codes-understand">
                    @lang('ui::actions.understand')
                </button>
            </div>
        </div>
    @endslot
</x-ark-modal>
