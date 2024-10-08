@props([
    'id',
    'images'             => [],
    'dimensions'         => 'w-full h-48',
    'imageHeight'        => 'h-28',
    'uploadText'         => trans('ui::forms.upload-image-collection.drag_drop_browse'),
    'deleteTooltip'      => trans('ui::forms.upload-image-collection.delete_image'),
    'minWidth'           => (int) config('ui.upload.image-collection.dimensions.min-width'),
    'minHeight'          => (int) config('ui.upload.image-collection.dimensions.min-height'),
    'maxWidth'           => (int) config('ui.upload.image-collection.dimensions.max-width'),
    'maxHeight'          => (int) config('ui.upload.image-collection.dimensions.max-height'),
    'width'              => null,
    'height'             => null,
    'maxFilesize'        => '5MB',
    'quality'            => 0.8,
    'acceptMime'         => (string) config('ui.upload.image-collection.accept-mime'),
    'uploadErrorMessage' => null,
    'sortable'           => false,
])

<div
    x-data="CompressImage(
        'image-collection-upload-{{ $id }}',
        @entangle($attributes->wire('model')).live,
        {{ $minWidth }},
        {{ $minHeight }},
        {{ $maxWidth }},
        {{ $maxHeight }},
        '{{ $width }}',
        '{{ $height }}',
        '{{ $maxFilesize }}',
        {{ $quality }}
    )"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false; livewire.dispatch('uploadError', '{{ $uploadErrorMessage }}');"
    class="relative z-0 space-y-8"
>
    <div class="rounded-xl p-1.5 border-2 border-dashed border-theme-primary-100 dark:border-theme-secondary-800 relative {{ $dimensions }} group">
        <input
            id="image-collection-upload-{{ $id }}"
            type="file"
            class="absolute w-full h-full opacity-0 cursor-pointer"
            @change="validateImage"
            accept="{{ $acceptMime }}"
            multiple
        />

        <div class="flex flex-col justify-center items-center space-y-2 w-full h-full rounded-xl dark:bg-black bg-theme-primary-50 transition-default dark:group-hover:bg-theme-secondary-800">
            <div class="text-theme-primary-500">
                <x-ark-icon name="cloud-arrow-up" size="lg"/>
            </div>

            <div class="font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">{!! $uploadText !!}</div>

            <div
                class="flex flex-col space-y-1 text-xs font-semibold text-center sm:flex-row sm:space-y-0 sm:space-x-1 text-theme-secondary-500 chunk-header">
                @lang('ui::forms.upload-image-collection.requirements', [
                    'width'    => $minWidth,
                    'height'   => $minHeight,
                    'filesize' => $maxFilesize,
                    'quantity' => $this->getImageCollectionMaxQuantity(),
                ])
            </div>
        </div>

        <div x-show="isUploading" x-cloak>
            <x-ark-loading-spinner class="right-0 bottom-0 left-0 rounded-xl" :dimensions="$dimensions"/>
        </div>
    </div>

    @if (count($images) > 0)
        <div class="flex flex-wrap -m-3" @if($sortable)wire:sortable="updateImageOrder"@endif>
            @foreach ($images as $image)
                <div class="p-3 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6" wire:sortable.item="{{ $image['url'] }}" wire:key="image-{{ $image['url'] }}">
                    <div class="aspect-w-16 aspect-h-9">
                        <div>
                            <img src="{{ $image['url'] }}" class="object-cover w-full h-full rounded-xl border border-theme-secondary-300 dark:border-theme-secondary-800" alt="">
                        </div>

                        <div class="absolute inset-0 opacity-0 hover:opacity-100 transition-default">
                            <div @class([
                                'select-none rounded-xl flex flex-col items-center justify-center opacity-70 w-full h-full',
                                'cursor-pointer bg-theme-secondary-900' => $sortable,
                                'border-6 border-theme-secondary-900'   => ! $sortable,
                            ])>
                                @if($sortable)
                                    <x-ark-icon name="drag" size="lg" class="text-white"/>
                                    <p class="mt-3 text-xs font-semibold text-theme-secondary-500">
                                        @lang('ui::actions.drag_to_reposition')
                                    </p>
                                @endif
                            </div>

                            <button
                                type="button"
                                data-action
                                class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                                wire:click="deleteImage('{{ $image['url'] }}')"
                                data-tippy-hover="{{ $deleteTooltip }}"
                            >
                                <x-ark-icon name="cross" size="sm"/>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
