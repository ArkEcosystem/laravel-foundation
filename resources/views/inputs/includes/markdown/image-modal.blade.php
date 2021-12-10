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
            {{-- <div class="w-full mb-4">
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
                        <label class="block rounded-xl w-full h-full focus-within:border-theme-primary-500 p-1.5 border-2 border-dashed border-theme-primary-100 dark:border-theme-secondary-800">
                            <div class="inline-block w-full h-full bg-center bg-no-repeat bg-cover rounded-xl bg-theme-primary-50 dark:bg-black dark:hover:bg-theme-secondary-800 transition-default cursor-pointer hover:bg-theme-primary-100 transition-default" role="button">
                                <input id="image" type="file" class="sr-only" accept="image/jpg,image/jpeg,image/png,jpg,png" @change="imageHandler">
                            </div>

                            <div class="flex absolute top-2 right-2 bottom-2 left-2 flex-col justify-center items-center space-y-2 rounded-xl cursor-pointer pointer-events-none" role="button">
                                <div class="text-theme-primary-500">
                                    <x-ark-icon name="upload-cloud" size="lg"/>
                                </div>

                                <div class="link font-semibold">@lang('ui::markdown.modals.image.form.browse_files')</div>

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

