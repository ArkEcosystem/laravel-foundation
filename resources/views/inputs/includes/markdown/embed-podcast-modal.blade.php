<x-ark-js-modal
    init
    name="embedPodcastModal"
    :title="trans('ui::markdown.modals.embedPodcast.title')"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="embedPodcastModalForm" @submit.prevent="Livewire.dispatch('embedPodcastModal', $event)">
            <x-ark-input
                type="text"
                name="url"
                :label="trans('ui::markdown.modals.embedPodcast.form.url')"
                class="w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="embedPodcastModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

