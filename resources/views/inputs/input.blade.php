@props ([
    'name',
    'errors' => null, // TODO: remove when #449 is merged...
    'id' => null,
    'model' => null,
    'label' => null,
    'deferred' => false,
    'required' => false,
    'inputClass' => '',
    'auxiliaryTitle' => '',
    'noModel' => false,
    'hideLabel' => false,
    'tooltip' => null,
    'tooltipClass' => null,
    'tooltipType' => null,
])

@php
    $id ??= $name;
    $model ??= $name;
@endphp

<div {{ $attributes->only('class') }} >
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'            => $name,
                'errors'          => $errors,
                'id'              => $id,
                'label'           => $label,
                'tooltip'         => $tooltip,
                'tooltipClass'    => $tooltipClass,
                'tooltipType'     => $tooltipType,
                'required'        => $required,
                'auxiliaryTitle'  => $auxiliaryTitle,
            ])
        @endunless

        <div class="input-wrapper">
            @include('ark::inputs.includes.input-field', [
                'name'         => $name,
                'errors'       => $errors,
                'id'           => $id,
                'inputClass'   => $inputClass,
                'noModel'      => $noModel,
                'model'        => $model,
                'deferred'     => $deferred,
            ])

            @error($name)
                @include('ark::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id' => $id,
                ])
            @enderror
        </div>
    </div>
</div>
