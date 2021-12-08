<x-ark-js-modal
    init
    name="embedLinkModal"
    :title="trans('ui::markdown.modals.embedLink.title')"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="embedLinkModalForm" @submit.prevent="Livewire.emit('embedLinkModal', $event)">
            <x-ark-input
                type="text"
                name="url"
                :label="trans('ui::markdown.modals.embedLink.form.url')"
                class="w-full"
            />
            <x-ark-input
                type="text"
                name="caption"
                :label="trans('ui::markdown.modals.embedLink.form.caption')"
                class="mt-4 w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="embedLinkModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

