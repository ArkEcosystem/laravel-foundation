<x-ark-js-modal
    init
    name="linkCollectionModal"
    :title="trans('ui::markdown.modals.linkCollection.title')"
    width-class="max-w-lg"
    x-data="{
        links: [
            {
                id: Date.now() + Math.random(),
                name: '',
                path: '',
            },
        ],
        inputHandler() {
            const newLinks = this.links.filter(link => {
                return link.name !== '' || link.path !== '';
            });

            newLinks.push({
                id: Date.now() + Math.random(),
                name: '',
                path: '',
            });

            this.links = newLinks;
        },
        onHidden() {
            this.links = [
                {
                    id: Date.now() + Math.random(),
                    name: '',
                    path: '',
                },
            ];
        }
    }"
>
    @slot('description')
        <form id="linkCollectionModalForm" @submit.prevent="Livewire.emit('linkCollectionModal', $event)" class="space-y-4">
            <template x-for="(link, index) in links" x-key="`${link.id}:${index}`">
                <div class="flex space-x-4" >
                    <x-ark-input
                        type="text"
                        name="name"
                        :label="trans('ui::markdown.modals.linkCollection.form.name')"
                        class="w-full"
                        x-model="links[index].name"
                        x-on:input="inputHandler"
                    />
                    <x-ark-input
                        type="text"
                        name="path"
                        :label="trans('ui::markdown.modals.linkCollection.form.path')"
                        class="w-full"
                        x-model="links[index].path"
                        x-on:input="inputHandler"
                    />
                </div>
            </template>
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="linkCollectionModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

