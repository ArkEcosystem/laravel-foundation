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
    'keydownEnter'   => null,
    'attributes'     => $attributes,
    'autocapitalize' => 'none',
])

<input
    type="{{ $type }}"
    id="{{ $id ?? $name }}"
    name="{{ $name }}"
    class="{{ $inputClass }} {{ $inputTypeClass }} @if ($errors) @error($name) {{ $errorClass }} @enderror @endif"
    @unless ($noModel) wire:model="{{ $model ?? $name }}" @endUnless
    {{-- @TODO: remove --}}
    @if ($keydownEnter) wire:keydown.enter="{{ $keydownEnter }}" @endif
    autocapitalize="{{ $autocapitalize }}"

    {{ $attributes->except([
        'autocapitalize',
        'class',
        'container-class',
        'hide-label',
        'errors',
        'id',
        'model',
        'slot',
        'type',
        'wire:model',
        'keydown-enter',
    ]) }}
/>
