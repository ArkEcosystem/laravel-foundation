@props ([
    'type' => 'info',
    'title' => null,
    'message' => null,
    'wireClose' => false,
    'alpineClose' => false,
    'target' => null,
    'hideSpinner' => false,
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
@endphp

<div role="alert" aria-live="polite" {{ $attributes->class(['toast', $toastClass]) }}>
    <span class="toast-icon">
        <x-ark-icon :name="$icon" size="sm" />
        <span class="text-sm font-semibold sm:hidden">{{ $title ?? trans('ui::toasts.'.$type) }}</span>
    </span>

    <div class="toast-body">
        @if ($message)
            {{ $message }}
        @else
            {!! $slot !!}
        @endif
    </div>

    <button
        @if ($wireClose) wire:click="{{ $wireClose }}" @endif
        @if ($alpineClose) @click="{{ $alpineClose }}" @endif
        type="button"
        class="toast-button"
        @if ($target)
        wire:loading.remove
        wire:target="{{ $target }}"
        @endif
    >
        <x-ark-icon name="cross" size="sm" />
    </button>

    @unless ($hideSpinner)
        <div
            class="toast-spinner"
            @if ($target)
            wire:loading
            wire:target="{{ $target }}"
            @endif
        >
            <x-ark-spinner-icon circle-color="spinner" :stroke-width="3" />
        </div>
    @endunless
</div>
