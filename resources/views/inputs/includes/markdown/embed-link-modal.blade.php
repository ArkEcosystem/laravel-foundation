<x-ark-js-modal
    init
    name="embedLinkModal"
    title="Add Embed Link"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="embedLinkModalForm" @submit.prevent="Livewire.emit('embedLinkModal', $event)">
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
                class="mt-4 w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">Cancel</a>

        <button type="submit" class="button-primary" form="embedLinkModalForm">
            Ok
        </button>
    @endslot
</x-ark-js-modal>

