@props ([
    'name',
    'errors' => null,
    'value' => null,
    'id' => null,
    'model' => null,
    'label' => null,
    'icon' => null,
    'deferred' => false,
    'required' => false,
    'inputClass' => '',
    'suffix' => '',
    'auxiliaryTitle' => '',
    'noModel' => false,
    'hideLabel' => false,
    'tooltip' => null,
])

@php
    $id ??= $name;
    $model ??= $name;
@endphp

<div
    x-data="{ isDirty: {{ !! ($value ?? false) ? 'true' : 'false' }} }"
    {{ $attributes->only('class') }}
>
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

        <div
            @class([
                'input-wrapper input-wrapper-with-suffix',
                'input-text--error' => $errors->has($name),
            ])
            x-bind:class="{ 'input-wrapper-with-suffix--dirty': !! isDirty }"
        >
            @include('ark::inputs.includes.input-field', [
                'name'           => $name,
                'errors'         => null,
                'id'             => $id,
                'inputTypeClass' => 'input-text-with-suffix',
                'inputClass'     => $inputClass,
                'noModel'        => $noModel,
                'model'          => $model,
                'deferred'       => $deferred,
                'attributes'     => $attributes->merge(['x-on:change' => 'isDirty = !! $event.target.value']),
            ])

            @if($suffix)
                <div class="relative input-suffix bg-theme-primary-50 dark:bg-theme-secondary-800">
                    {{ $suffix }}

                    @error($name)
                        @include('ark::inputs.includes.input-error-tooltip', [
                            'error' => $message,
                            'id' => $id
                        ])
                    @enderror
                </div>
            @else
                @error($name)
                    @include('ark::inputs.includes.input-error-tooltip', [
                        'error' => $message,
                        'id' => $id
                    ])
                @enderror
            @endif
        </div>
    </div>
</div>
