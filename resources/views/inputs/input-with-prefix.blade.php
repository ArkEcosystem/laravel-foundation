@props ([
    'name',
    'errors' => null, // TODO: remove when #449 is merged...
    'value' => null,
    'id' => null,
    'model' => null,
    'label' => null,
    'icon' => null,
    'deferred' => false,
    'required' => false,
    'inputClass' => '',
    'prefixClass' => 'bg-theme-primary-50 dark:bg-theme-secondary-800',
    'prefix' => '',
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
    x-data="{ isDirty: {{ $value ? 'true' : 'false' }} }"
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
                'input-wrapper input-wrapper-with-prefix',
                'input-text--error' => $errors->has($name),
            ])
            x-bind:class="{ 'input-wrapper-with-prefix--dirty': !! isDirty }"
        >
            @if ($icon)
                @include('ark::inputs.includes.input-prefix-icon', [
                    'icon'     => $icon,
                    'position' => 'left',
                ])
            @elseif($prefix)
                <div @class(['input-prefix', $prefixClass])>
                    {{ $prefix }}
                </div>
            @endif

            @include('ark::inputs.includes.input-field', [
                'name'           => $name,
                'errors'         => null,
                'id'             => $id,
                'inputTypeClass' => 'input-text-with-prefix',
                'inputClass'     => $inputClass,
                'noModel'        => $noModel,
                'model'          => $model ?? $name,
                'deferred'       => $deferred,
                'attributes'     => $attributes->merge([
                    'x-on:change' => 'isDirty = !! $event.target.value',
                    'value' => $value,
                ]),
            ])

            @error($name)
                @include('ark::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id' => $id
                ])
            @enderror
        </div>
    </div>
</div>
