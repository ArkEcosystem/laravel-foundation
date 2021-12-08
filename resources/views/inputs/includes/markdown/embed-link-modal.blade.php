@push('footer')
    <x-ark-js-modal
        init
        name="embed-link-modal"
        title="Add Embed Link"
        width-class="max-w-lg"
    >
        @slot('description')
            <form id="embed-link-form" @submit.prevent="Livewire.emit('embedLink', $event)">
                <x-ark-input
                    type="text"
                    name="url"
                    label="URL"
                    class="w-full"
                />
                <x-ark-input
                    type="text"
                    name="caption"
                    label="Caption"
                    class="w-full mt-4"
                />
            </form>
        @endslot

        @slot('buttons')
            <button @click="hide" type="button" class="button-secondary">Cancel</a>

            <button type="submit" class="button-primary" form="embed-link-form">
                Ok
            </button>
        @endslot
    </x-ark-js-modal>
@endpush
