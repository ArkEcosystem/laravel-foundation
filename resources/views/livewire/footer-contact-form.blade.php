<form id="contact" wire:submit.prevent="send" class="extended-footer-contact flex-1 lg:pl-6">
    <x-honeypot livewire-model="extraFields" />

    <div class="space-y-4">
        <h3 class="text-theme-secondary-200">@lang ('ui::pages.extended-footer.contact.title')</h3>

        <div>@lang ('ui::pages.extended-footer.contact.description')</div>
    </div>

    <div class="mt-6 space-y-5">
        <div class="flex flex-col space-y-5 sm:flex-row sm:space-x-5 sm:space-y-0">
            <x-ark-input name="contact:name" model="state.name" class="flex-1" />

            <x-ark-input name="contact:email" model="state.email" type="email" class="flex-1" />
        </div>

        <x-ark-textarea name="contact:message" model="state.message" :placeholder="trans('ui::pages.extended-footer.contact.placeholder')" rows="1" />
    </div>

    <div class="mt-8">
        <div class="w-full" wire:loading wire:target="send">
            <div class="flex h-11 w-full items-center justify-center rounded bg-theme-secondary-800">
                <x-ark-loader-icon class="h-7 w-7 text-theme-secondary-900" path-class="text-theme-primary-600"
                    stroke="2" />
            </div>
        </div>

        <button type="submit" class="w-full" wire:loading.remove wire:target="send">
            @lang ('ui::actions.send')
        </button>
    </div>
</form>
