<x-ark-js-modal
    init
    name="linkModal"
    :title="trans('ui::markdown.modals.image.title')"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="linkModalForm" @submit.prevent="Livewire.dispatch('linkModal', $event)">
            <x-ark-input
                type="text"
                name="url"
                :label="trans('ui::markdown.modals.link.form.url')"
                class="w-full"
            />

            <x-ark-input
                type="text"
                name="text"
                :label="trans('ui::markdown.modals.link.form.text')"
                class="mt-4 w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="linkModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

