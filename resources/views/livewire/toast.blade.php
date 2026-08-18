<div class="fixed bottom-0 right-0 z-50 flex flex-col items-end space-y-3 p-5">
    @foreach ($toasts as $key => $toast)
        <div class="z-20 flex cursor-pointer" x-data="{
            dismiss() {
                Livewire.dispatch('dismissToast', { id: '{{ $key }}' })
            }
        }" x-init="$nextTick(() => setTimeout(() => dismiss(), 5000))"
            wire:click="dismissToast('{{ $key }}')" wire:key="{{ $key }}">
            <x-ark-toast :type="$toast['type']" wire-close="dismissToast('{{ $key }}')" target="dismissToast">
                <x-slot name='message'>
                    {!! $toast['message'] !!}
                </x-slot>
            </x-ark-toast>
        </div>
    @endforeach
</div>
