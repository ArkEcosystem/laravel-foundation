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
    'deferred'       => false,
    'debounce'       => null,
])

<input
    class="{{ $inputClass }} {{ $inputTypeClass }} @if ($errors) @error($name) {{ $errorClass }} @enderror @endif"
    @unless ($noModel)
    @if ($deferred)
    wire:model="{{ $model ?? $name }}"
    @elseif ($debounce === true)
    wire:model.live.debounce="{{ $model ?? $name }}"
    @elseif (is_string($debounce))
    wire:model.live.debounce.{{ $debounce }}="{{ $model ?? $name }}"
    @else
    wire:model.live="{{ $model ?? $name }}"
    @endif
    @endUnless
    {{ $attributes->except([
        'class',
        'container-class',
        'hide-label',
        'errors',
        'model',
        'slot',
        'wire:model',
        'deferred',
        'debounce',
    ])->merge([
        'type' => $type,
        'id' => $id ?? $name,
        'name' => $name,
        'autocapitalize' => 'none',
    ]) }}
/>
