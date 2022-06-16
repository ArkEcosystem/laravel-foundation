<div>
    @if($this->modalShown)
    <x-ark-modal
        title-class="header-2"
        width-class="max-w-lg"
        wire-close="close"
    >
        <x-slot name="title">
            Remove User
        </x-slot>

        <x-slot name="description">
            <p>Are you sure you want to remove this user? Please enter user's email address to confirm.</p>

            <div class="mt-4">
                <x-ark-input
                    type="text"
                    name="userEmailConfirmation"
                    wire:model="userEmailConfirmation"
                    :errors="$errors"
                    placeholder="Enter user's email"
                    hide-label
                />
            </div>
        </x-slot>

        <x-slot name="buttons">
            <div class="flex flex-col-reverse justify-end space-y-4 space-y-reverse w-full sm:flex-row sm:space-y-0 sm:space-x-3">
                <button
                    type="button"
                    dusk="confirm-password-form-cancel"
                    class="button-secondary"
                    wire:click="close"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    dusk="confirm-password-form-submit"
                    class="inline-flex justify-center items-center space-x-2 button-cancel"
                    wire:click="deleteUser"
                    @unless($this->canSubmit)
                        disabled
                    @endunless
                >
                    <x-ark-icon name="trash" size="sm" />

                    <span>Delete</span>
                </button>
            </div>
        </x-slot>
    </x-ark-modal>
    @endif
</div>
