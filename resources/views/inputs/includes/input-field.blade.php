@props([
    'name',
    'errors'         => null,
    'type'           => 'text',
    'id'             => null,
    'inputClass'     => '',
    'inputTypeClass' => 'input-text',
    'errorClass'     => 'input-text--error',
    'noModel'        => false,
    'model'          => null,
    'attributes'     => $attributes,
])

<input
    class="{{ $inputClass }} {{ $inputTypeClass }} @if ($errors) @error($name) {{ $errorClass }} @enderror @endif"
    @unless ($noModel)
    wire:model="{{ $model ?? $name }}"
    @endUnless
    {{ $attributes->except([
        'class',
        'container-class',
        'hide-label',
        'errors',
        'model',
        'slot',
        'wire:model',
    ])->merge([
        'type' => $type,
        'id' => $id ?? $name,
        'name' => $name,
        'autocapitalize' => 'none',
    ]) }}
/>
