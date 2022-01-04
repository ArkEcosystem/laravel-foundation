<x-ark-js-modal
    init
    name="embedTweetModal"
    :title="trans('ui::markdown.modals.embedTweet.title')"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="embedTweetModalForm" @submit.prevent="Livewire.emit('embedTweetModal', $event)">
            <x-ark-input
                type="text"
                name="url"
                :label="trans('ui::markdown.modals.embedTweet.form.url')"
                :placeholder="trans('ui::markdown.modals.embedTweet.form.url_placeholder')"
                class="w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="embedTweetModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

