<div class="relative flex flex-col {{ $alignment }}">
    <form class="{{ $formClass }}">
        <x-ark-upload-image-single
            id="profile-image"
            :dimensions="$dimensions"
            :readonly="$readonly"
            :image="$this->user->photo"
            wire:model.live="imageSingle"
            :upload-text="__('ui::forms.upload-avatar.upload_avatar')"
            :delete-tooltip="__('ui::forms.upload-avatar.delete_avatar')"
            :with-crop="$withCrop"
            :crop-options="$cropOptions"
        />
    </form>
</div>
