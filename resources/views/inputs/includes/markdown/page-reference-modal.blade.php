<x-ark-js-modal
    init
    name="pageReferenceModal"
    :title="trans('ui::markdown.modals.pageReference.title')"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="pageReferenceModalForm" @submit.prevent="Livewire.dispatch('pageReferenceModal', $event)" class="space-y-4">

            <x-ark-input
                type="text"
                name="url"
                :label="trans('ui::markdown.modals.pageReference.form.url')"
                class="w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="pageReferenceModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

