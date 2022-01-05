<x-ark-js-modal
    init
    name="imageModal"
    :title="trans('ui::markdown.modals.image.title')"
    width-class="max-w-lg"
    {{-- @TODO: Image upload handling related code --}}
    {{-- x-data="{
        source: 'file',
        imageHandler(e) {
            e.preventDefault();
            const files = e.target.files;
        }
    }" --}}
>
    @slot('description')
        <form id="imageModalForm" @submit.prevent="Livewire.emit('imageModal', $event)">
            {{-- @TODO: Add file upload --}}
            {{-- <div class="mb-4 w-full">
                <div class="input-group">
                    <label for="image" class="items-center input-label">@lang('ui::markdown.modals.image.form.source')</label>

                    <div class="grid grid-cols-2 input-wrapper">
                        <button
                            type="button"
                            class="py-3 px-5 font-semibold leading-tight rounded-l transition-default"
                            x-on:click="source = 'file'"
                            :class="{
                                'text-white bg-theme-primary-600 hover:bg-theme-primary-700': source === 'file',
                                'bg-theme-primary-100 text-theme-primary-600 hover:text-white hover:bg-theme-primary-700': source === 'link',
                            }"
                        >@lang('ui::markdown.modals.image.form.file')</button>
                        <button
                            type="button"
                            class="py-3 px-5 font-semibold leading-tight rounded-r transition-default"
                            x-on:click="source = 'link'"
                            :class="{
                                'text-white bg-theme-primary-600 hover:bg-theme-primary-700': source === 'link',
                                'bg-theme-primary-100 text-theme-primary-600 hover:text-white hover:bg-theme-primary-700': source === 'file',
                            }"
                        >@lang('ui::markdown.modals.image.form.link')</button>
                    </div>
                </div>
                <input type="hidden" name="source" x-bind:value="source" />
            </div> --}}

            <x-ark-input
                type="text"
                name="image"
                :label="trans('ui::markdown.modals.image.form.image')"
                class="w-full"
            />

            {{-- @TODO: Add file upload --}}
            {{-- <template x-if="source === 'file'">
                <div>
                    <label for="image" class="items-center input-label">
                        @lang('ui::markdown.modals.image.form.image')
                    </label>
                    <div class="relative w-full h-36 input-wrapper">
                        <label class="block p-1.5 w-full h-full rounded-xl border-2 border-dashed border-theme-primary-100 dark:border-theme-secondary-800 focus-within:border-theme-primary-500">
                            <div class="inline-block w-full h-full bg-center bg-no-repeat bg-cover rounded-xl cursor-pointer dark:bg-black bg-theme-primary-50 transition-default dark:hover:bg-theme-secondary-800 hover:bg-theme-primary-100" role="button">
                                <input id="image" type="file" class="sr-only" accept="image/jpg,image/jpeg,image/png,jpg,png" @change="imageHandler">
                            </div>

                            <div class="flex absolute top-2 right-2 bottom-2 left-2 flex-col justify-center items-center space-y-2 rounded-xl cursor-pointer pointer-events-none" role="button">
                                <div class="text-theme-primary-500">
                                    <x-ark-icon name="upload-cloud" size="lg"/>
                                </div>

                                <div class="font-semibold link">@lang('ui::markdown.modals.image.form.browse_files')</div>

                                <div class="text-xs font-semibold text-theme-secondary-500">
                                    @lang('ui::markdown.modals.image.form.file_restrictions', ['maxSize' => \ARKEcosystem\Foundation\Support\FileUpload::maxSizeFormatted()])
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </template> --}}

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

