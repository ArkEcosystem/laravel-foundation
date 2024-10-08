@props([
    'id',
    'image'                     => null,
    'dimensions'                => 'w-48 h-48',
    'uploadText'                => trans('ui::forms.upload-image.upload_image'),
    'deleteTooltip'             => trans('ui::forms.upload-image.delete_image'),
    'minWidth'                  => (int) config('ui.upload.image-single.dimensions.min-width'),
    'minHeight'                 => (int) config('ui.upload.image-single.dimensions.min-height'),
    'maxWidth'                  => (int) config('ui.upload.image-single.dimensions.max-width'),
    'maxHeight'                 => (int) config('ui.upload.image-single.dimensions.max-height'),
    'width'                     => 740,
    'height'                    => 740,
    'maxFilesize'               => '5MB',
    'quality'                   => 0.8,
    'acceptMime'                => (string) config('ui.upload.image-single.accept-mime'),
    'readonly'                  => false,
    'uploadErrorMessage'        => null,
    'deleteAction'              => 'deleteImageSingle',
    'withCrop'                  => false,
    'cropOptions'               => "{}",
    'cropTitle'                 => trans('ui::modals.crop-image.title'),
    'cropMessage'               => trans('ui::modals.crop-image.message'),
    'cropModalWidth'            => 'max-w-xl',
    'cropCancelButton'          => trans('ui::actions.back'),
    'cropSaveButton'            => trans('ui::actions.save'),
    'cropCancelButtonClass'     => 'button-secondary flex items-center justify-center',
    'cropSaveButtonClass'       => 'button-primary flex items-center justify-center',
    'cropSaveIcon'              => false,
    'cropFillColor'             => '#fff',
    'cropImageSmoothingEnabled' => true,
    'cropImageSmoothingQuality' => 'high',
    'cropEndpoint'              => route('cropper.upload-image'),
    'displayText'               => true,
    'uploadTooltip'             => null,
    'iconSize'                  => 'lg',
    'withoutBorder'             => false,
])

<div
    @if($withCrop)
    x-data="CropImage(
        {{ $cropOptions }},
        @entangle($attributes->wire('model')).live,
        'image-single-upload-{{ $id }}',
        'image-single-crop-{{ $id }}',
        'crop-modal-{{ $id }}',
        {{ $minWidth }},
        {{ $minHeight }},
        {{ $maxWidth }},
        {{ $maxHeight }},
        @if($width) {{ $width }} @else null @endif,
        @if($height) {{ $height }} @else null @endif,
        '{{ $maxFilesize }}',
        '{{ $cropFillColor }}',
        {{ $cropImageSmoothingEnabled }},
        '{{ $cropImageSmoothingQuality }}',
        '{{ $cropEndpoint }}',
    )"
    @else
    x-data="CompressImage(
        'image-single-upload-{{ $id }}',
        @entangle($attributes->wire('model')).live,
        {{ $minWidth }},
        {{ $minHeight }},
        {{ $maxWidth }},
        {{ $maxHeight }},
        @if($width) {{ $width }} @else null @endif,
        @if($height) {{ $height }} @else null @endif,
        '{{ $maxFilesize }}',
        {{ $quality }}
    )"
    @endif
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false; livewire.dispatch('uploadError', '{{ $uploadErrorMessage }}');"
    class="flex-shrink-0 relative {{ $dimensions }}"
>
    <div @class([
        'rounded-xl w-full h-full focus-within:border-theme-primary-500',
        'border-2 p-1.5 border-dashed border-theme-primary-100 dark:border-theme-secondary-800' => ! $image && ! $withoutBorder,
    ])>
        <div
            @if ($image)
            style="background-image: url('{{ $image }}')"
            @endif
            @class([
                'inline-block w-full h-full bg-center bg-no-repeat bg-cover rounded-xl bg-theme-primary-50 dark:bg-black dark:hover:bg-theme-secondary-800 transition-default',
                'cursor-pointer hover:bg-theme-primary-100 transition-default' => ! $readonly,
            ])
            @unless($readonly)
            @click.self="select"
            role="button"
            @if($uploadTooltip) data-tippy-hover="{{ $uploadTooltip }}" @endif
            @endunless
        >
            @unless($readonly)
                <input
                    id="image-single-upload-{{ $id }}"
                    type="file"
                    class="sr-only"
                    accept="{{ $acceptMime }}"
                    @if($withCrop)
                    @change="validateImage"
                    @else
                    {{ $attributes->wire('model') }}
                    @endif
                />
            @endunless
        </div>

        @if (!$image && !$readonly)
            <div
                wire:key="upload-button-{{ $id }}"
                class="flex absolute inset-2 flex-col justify-center items-center space-y-2 rounded-xl cursor-pointer pointer-events-none"
                role="button"
            >
                <div class="text-theme-primary-500">
                    <x-ark-icon name="cloud-arrow-up" :size="$iconSize"/>
                </div>

                @if ($displayText)
                <div class="font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">{!! $uploadText !!}</div>

                <div class="text-xs font-semibold text-theme-secondary-500">
                    @lang('ui::forms.upload-image.min_size', [$minWidth, $minHeight])
                </div>
                <div class="text-xs font-semibold text-theme-secondary-500">
                    @lang('ui::forms.upload-image.max_filesize', [$maxFilesize])
                </div>
                @endif
            </div>
        @endif


        @unless($readonly)
            <div
                wire:key="delete-button-{{ $id }}"
                @class([
                    'rounded-xl absolute top-0 opacity-0 hover:opacity-100 transition-default w-full h-full',
                    'hidden' => ! $image,
                ])
            >
                <div class="absolute inset-0 w-full h-full rounded-xl opacity-70 pointer-events-none border-6 border-theme-secondary-900 transition-default"></div>

                <button
                    wire:loading.attr="disabled"
                    type="button"
                    class="absolute top-0 right-0 p-1 -mt-2 -mr-2 rounded cursor-pointer bg-theme-danger-100 text-theme-danger-500"
                    wire:click="{{ $deleteAction }}"
                    data-tippy-hover="{{ $deleteTooltip }}"
                >
                    <x-ark-icon name="cross" size="sm"/>
                </button>
            </div>

            <div x-show="isUploading" x-cloak>
                <x-ark-loading-spinner class="right-0 bottom-0 left-0 rounded-xl" :dimensions="$dimensions"/>
            </div>
        @endunless
    </div>

    <x-ark-js-modal
        name="crop-modal-{{ $id }}"
        class="w-full max-w-2xl text-left"
        close-button-only
        x-data="Modal.alpine({
            onShown() {
                Livewire.dispatch('cropModalShown', '{{ $id }}');
            },
            onBeforeHide() {
                Livewire.dispatch('cropModalBeforeHide', '{{ $id }}');
            }
        }, 'crop-modal-{{ $id }}', { disableFocusTrap: true })"
    >
        @slot('title')
            {{ $cropTitle }}
        @endslot

        @slot('description')
            @if($cropMessage)
                <p>{!! $cropMessage !!}</p>
            @endif

            <div class="relative -mx-8 mt-8 sm:-mx-10 h-75">
                <div x-show="isPreparingImage" class="relative w-full h-40">
                    <x-ark-loading-spinner class="right-0 bottom-0 left-0" spinner-dimensions="w-8 h-8" dimensions="w-full h-full" />
                </div>

                <img :class="{ 'invisible absolute' : isPreparingImage }" id="image-single-crop-{{ $id }}" src="" alt="" >
            </div>
        @endslot

        @slot('buttons')
            <button type="button" class="{{ $cropCancelButtonClass }}" @click="Livewire.dispatch('discardCroppedImage')" dusk="crop-cancel-button">
                {{ $cropCancelButton }}
            </button>

            <button type="button" class="{{ $cropSaveButtonClass }}" @click="Livewire.dispatch('saveCroppedImage')" dusk="crop-save-button">
                @if($cropSaveIcon)
                    <x-ark-icon :name="$cropSaveIcon" size="sm" class="inline my-auto mr-2"/>
                @endif

                {{ $cropSaveButton }}
            </button>
        @endslot
    </x-ark-js-modal>
</div>
