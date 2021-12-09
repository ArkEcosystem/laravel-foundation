<x-ark-js-modal
    init
    name="imageModal"
    :title="trans('ui::markdown.modals.image.title')"
    width-class="max-w-lg"
    x-data="{
        source: 'file'
    }"
>
    @slot('description')
        <form id="imageModalForm" @submit.prevent="Livewire.emit('imageModal', $event)">
            <div class="w-full mb-4">
                <div class="input-group">
                    <label for="image" class="items-center input-label">@lang('ui::markdown.modals.image.form.source')</label>

                    <div class="grid grid-cols-2 input-wrapper">
                        <button
                            type="button"
                            class="rounded-l transition-default leading-tight font-semibold  px-5 py-3"
                            x-on:click="source = 'file'"
                            :class="{
                                'text-white bg-theme-primary-600 hover:bg-theme-primary-700': source === 'file',
                                'bg-theme-primary-100 text-theme-primary-600 hover:text-white hover:bg-theme-primary-700': source === 'link',
                            }"
                        >@lang('ui::markdown.modals.image.form.file')</button>
                        <button
                            type="button"
                            class="rounded-r transition-default leading-tight font-semibold px-5 py-3"
                            x-on:click="source = 'link'"
                            :class="{
                                'text-white bg-theme-primary-600 hover:bg-theme-primary-700': source === 'link',
                                'bg-theme-primary-100 text-theme-primary-600 hover:text-white hover:bg-theme-primary-700': source === 'file',
                            }"
                        >@lang('ui::markdown.modals.image.form.link')</button>
                    </div>
                </div>
                <input type="hidden" name="source" x-bind:value="source" />
            </div>
            <template x-if="source === 'link'">
                <x-ark-input
                    type="text"
                    name="image"
                    :label="trans('ui::markdown.modals.image.form.image')"
                    class="w-full"
                />
            </template>
            <template x-if="source === 'file'">
                <div class="relative w-full h-36">
                    <div class="rounded-xl w-full h-full focus-within:border-theme-primary-500 p-1.5 border-2 border-dashed border-theme-primary-100 dark:border-theme-secondary-800">
                        <div class="inline-block w-full h-full bg-center bg-no-repeat bg-cover rounded-xl bg-theme-primary-50 dark:bg-black dark:hover:bg-theme-secondary-800 transition-default cursor-pointer hover:bg-theme-primary-100 transition-default" role="button">
                            <input id="image-single-upload-profile-image" type="file" class="sr-only" accept="image/jpg,image/jpeg,image/png,jpg,png" @change="validateImage">
                        </div>

                        <div class="flex absolute top-2 right-2 bottom-2 left-2 flex-col justify-center items-center space-y-2 rounded-xl cursor-pointer pointer-events-none" role="button">
                            <div class="text-theme-primary-500">
                                <svg wire:key="ymTx9WUy" class="fill-current w-8 h-8" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 29.9 22.1" xml:space="preserve"><path d="M17 21.1h6.1c3.4 0 5.7-2.9 5.7-6.2.1-3.3-2.2-6.3-5.5-7-.2-4-3.5-7.1-7.5-6.9h-.1c-4.3 0-6.1 2.2-6.9 4.7-3.4-.8-5.7 1.8-4.8 4.8-1.6.6-3 2.7-3 5.3-.1 2.9 2.3 5.3 5.2 5.4h6.9V15h-2.4c-.5 0-.9-.4-.3-1s3.7-4.1 4.1-4.5c.5-.4.8-.6 1.4 0 .3.3 3.5 3.6 4 4.2s.5 1.2-.4 1.2H17v6.2z" fill="none" stroke="currentColor" stroke-width="2"></path></svg>
                            </div>

                            <div class="font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">Browse files</div>

                            <div class="text-xs font-semibold text-theme-secondary-500">
                                Min 148 x 148
                            </div>
                            <div class="text-xs font-semibold text-theme-secondary-500">
                                Max filesize 5MB
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </template>
            <x-ark-input
                type="text"
                name="description"
                :label="trans('ui::markdown.modals.image.form.description')"
                class="mt-4 w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="imageModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-ark-js-modal>

