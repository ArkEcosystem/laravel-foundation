<div class="flex fixed right-0 bottom-0 z-50 flex-col items-end p-5 space-y-3">
    @foreach ($toasts as $key => $toast)
        <div
            class="z-20 cursor-pointer"
            x-data="{
                dismiss() {
                    Livewire.emit('dismissToast', '{{ $key }}')
                }
            }"
            {{-- x-init="$nextTick(() => setTimeout(() => dismiss(), 5000))" --}}
            wire:click="dismissToast('{{ $key }}')"
            wire:key="{{ $key }}"
        >
            <x-ark-toast :type="$toast['type']" wire-close="dismissToast('{{ $key }}')" target="dismissToast">
                <x-slot name='message'>
                    {!! $toast['message'] !!}
                </x-slot>
            </x-ark-toast>
        </div>
    @endforeach
</div>
