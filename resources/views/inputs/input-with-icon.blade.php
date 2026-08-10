<div class="{{ $class ?? '' }}">
    <div class="input-group">
        @unless ($hideLabel ?? false)
            @include('ark::inputs.includes.input-label', [
                'name' => $name,
                'errors' => $errors,
                'id' => $id ?? $name,
                'label' => $label ?? null,
                'tooltip' => $tooltip ?? null,
                'required' => $required ?? false,
                'auxiliaryTitle' => $auxiliaryTitle ?? '',
            ])
        @endunless

        <div class="input-wrapper-with-icon {{ $containerClass ?? '' }} flex">
            <div class="flex-1">
                @include('ark::inputs.includes.input-field', [
                    'name' => $name,
                    'errors' => $errors,
                    'id' => $id ?? $name,
                    'inputTypeClass' => 'input-text-with-icon',
                    'errorClass' => 'input-text-with-icon--error',
                    'inputClass' => $inputClass ?? '',
                    'noModel' => $noModel ?? false,
                    'model' => $model ?? $name,
                    'deferred' => $deferred ?? false,
                    'debounce' => $debounce ?? null,
                ])
            </div>

            @if ($slot ?? false)
                <div>
                    <div class="{{ $slotClass ?? 'h-full' }} flex">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>

        <x-ark::inputs.input-error :name="$name" />
    </div>
</div>
