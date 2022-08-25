@props ([
    'name',
    'errors' => null,
    'id' => null,
    'model' => null,
    'label' => null,
    'deferred' => false,
    'required' => false,
    'inputClass' => '',
    'containerClass' => '',
    'slotClass' => 'h-full',
    'auxiliaryTitle' => '',
    'noModel' => false,
    'hideLabel' => false,
    'tooltip' => null,
])

@php
    $id ??= $name;
    $model ??= $name;
@endphp

<div {{ $attributes->only('class') }}>
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'           => $name,
                'errors'         => $errors,
                'id'             => $id,
                'label'          => $label,
                'tooltip'        => $tooltip,
                'required'       => $required,
                'auxiliaryTitle' => $auxiliaryTitle,
            ])
        @endunless

        <div class="flex input-wrapper-with-icon {{ $containerClass }}">
            <div class="flex-1">
                @include('ark::inputs.includes.input-field', [
                    'name'           => $name,
                    'errors'         => $errors,
                    'id'             => $id,
                    'inputTypeClass' => 'input-text-with-icon',
                    'errorClass'     => 'input-text-with-icon--error',
                    'inputClass'     => $inputClass,
                    'noModel'        => $noModel,
                    'model'          => $model,
                    'deferred'       => $deferred,
                ])
            </div>

            @if (! $slot->isEmpty())
                <div>
                    <div class="flex {{ $slotClass }}">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>

        <x-ark::inputs.input-error :name="$name" />
    </div>
</div>
