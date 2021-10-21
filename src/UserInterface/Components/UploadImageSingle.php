<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleUploadError;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

trait UploadImageSingle
{
    use HandleUploadError;
    use WithFileUploads;

    public $imageSingle;

    public $readonly = false;

    abstract public function render();

    abstract public function updatedImageSingle();

    abstract public function deleteImageSingle();

    public function validateImageSingle(string $propertyName = 'imageSingle'): void
    {
        $validator = Validator::make([
            $propertyName => $this->$propertyName,
        ], $this->imageSingleValidators($propertyName));

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->uploadError($error);
            }

            $validator->validate();
        }
    }

    public function imageSingleValidators(string $propertyName = 'imageSingle'): array
    {
        return [
            $propertyName => [
                'mimes:'.(string) config('ui.upload.image-single.accept-mime'),
                'max:'.(string) config('ui.upload.image-single.max-filesize'),
                Rule::dimensions()
                    ->minWidth((int) config('ui.upload.image-single.dimensions.min-width'))
                    ->minHeight((int) config('ui.upload.image-single.dimensions.min-height'))
                    ->maxWidth((int) config('ui.upload.image-single.dimensions.max-width'))
                    ->maxHeight((int) config('ui.upload.image-single.dimensions.max-height')),
            ],
        ];
    }
}
