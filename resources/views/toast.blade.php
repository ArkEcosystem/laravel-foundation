@props([
    'type' => 'info',
    'message' => '',
    'wireClose' => false,
    'alpineClose' => false,
    'target' => null,
])

@php
    $icon = Arr::get([
        'warning' => 'circle.exclamation-mark',
        'error' => 'circle.cross',
        'danger' => 'circle.cross',
        'success' => 'circle.check-mark',
        'info' => 'circle.info',
        'hint' => 'circle.question-mark',
    ], $type);

    $toastClass = Arr::get([
        'warning' => 'toast-warning',
        'error' => 'toast-danger',
        'danger' => 'toast-danger',
        'success' => 'toast-success',
        'info' => 'toast-info',
        'hint' => 'toast-hint',
    ], $type);

    $spinnerColor = Arr::get([
        'warning' => 'warning-200',
        'error' => 'danger-200',
        'danger' => 'danger-200',
        'success' => 'success-200',
        'info' => 'primary-200',
        'hint' => 'hint-200',
    ], $type);
@endphp

<div role="alert" aria-live="polite" {{ $attributes->class('toast')->class($toastClass) }}>
    <span class="toast-icon">
        <x-ark-icon :name="$icon" size="sm" />
    </span>

    <div class="toast-body">{{ $message }}</div>

    <button
        @if ($wireClose) wire:click="{{ $wireClose }}" @endif
        @if ($alpineClose) @click="{{ $alpineClose }}" @endif
        type="button"
        class="toast-button"
        @if ($target)
        wire:loading.remove
        wire:target="dismissToast"
        @endif
    >
        <x-ark-icon name="cross" size="sm" />
    </button>

    <div
        class="toast-spinner"
        @if ($target)
        wire:loading
        wire:target="dismissToast"
        @endif
    >
        <x-ark-spinner-icon :circle-color="$spinnerColor" :stroke-width="3" />
    </div>
</div>
