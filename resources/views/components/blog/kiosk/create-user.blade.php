<div class="space-y-6">
    <x-ark-input :errors="$errors" name="state.name" required />

    <x-ark-input :errors="$errors" name="state.email" required />

    <x-ark-input :errors="$errors" type="password" name="state.password" required />

    <x-ark-input :errors="$errors" type="file" name="state.photo" required />

    <button type="button" wire:click="save" class="button-primary">Save</button>
</div>
