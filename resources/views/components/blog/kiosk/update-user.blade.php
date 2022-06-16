<div class="space-y-6">
    <x-ark-input :errors="$errors" name="state.name" required />

    <x-ark-input :errors="$errors" name="state.email" required />

    <div>
        <x-ark-input :errors="$errors" type="password" name="state.password" />
        <span class="block mt-2 text-sm text-gray-400">Will update only if this value changes. Leave empty if you don't want to change user's password.</span>
    </div>

    <div>
        <x-ark-input :errors="$errors" type="file" name="state.photo" required />
        <a href="{{ $user->photo() }}" class="block mt-2 text-sm text-gray-400" target="_blank">{{ $user->photo() }}</a>
    </div>

    <div class="flex items-center space-x-5">
        <button type="button" wire:click="save" class="button-primary">Save</button>
    </div>
</div>
