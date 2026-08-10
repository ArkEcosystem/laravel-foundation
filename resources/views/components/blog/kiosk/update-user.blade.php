<div class="space-y-6">
    <x-ark-input :errors="$errors" name="state.name" required />

    <x-ark-input :errors="$errors" name="state.email" required />

    <div>
        <x-ark-input :errors="$errors" type="password" name="state.password" />
        <span class="text-gray-400 mt-2 block text-sm">Will update only if this value changes. Leave empty if you don't
            want to change user's password.</span>
    </div>

    <div>
        <x-ark-input :errors="$errors" type="file" name="state.photo" required />
        <a href="{{ $user->photo() }}" class="text-gray-400 mt-2 block text-sm" target="_blank">{{ $user->photo() }}</a>
    </div>

    <div class="flex items-center space-x-5">
        <button type="button" wire:click="save" class="button-primary">Save</button>
    </div>
</div>
