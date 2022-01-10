@props([
    'type' => 'info',
    'message' => '',
    'wireClose' => false,
    'alpineClose' => false,
])

@php
    $icon = Arr::get([
        'warning' => 'circle.exclamation-mark',
        'error' => 'circle.cross-big',
        'danger' => 'circle.cross-big',
        'success' => 'circle.check-mark-big',
        'info' => 'circle.info',
        'hint' => 'circle.question-mark-big',
    ], $type);

    $toastClass = Arr::get([
        'warning' => 'toast-warning',
        'error' => 'toast-danger',
        'danger' => 'toast-danger',
        'success' => 'toast-success',
        'info' => 'toast-info',
        'hint' => 'toast-hint',
    ], $type);
@endphp

<div {{ $attributes->merge(['class' => 'toast ' . $toastClass]) }}>
    <span class="toast-icon">
        <x-ark-icon :name="$icon"/>
    </span>

    <div class="toast-body">{{ $message }}</div>

    <button
        @if ($wireClose) wire:click="{{ $wireClose }}" @endif
        @if ($alpineClose) @click="{{ $alpineClose }}" @endif
        type="button"
        class="toast-button"
    >
        <x-ark-icon name="cross" />
    </button>
</div>
