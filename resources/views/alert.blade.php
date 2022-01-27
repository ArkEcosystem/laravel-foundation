@props([
    'message'      => null,
    'type'         => \ARKEcosystem\Foundation\UserInterface\Support\Enums\AlertType::INFO,
    'dismissible'  => false,
])

<div
    {{$attributes->class(['alert-wrapper alert-'.$type->value])}}
    @if($dismissible)
    x-data="{ show: true }"
    @endif
>
    <div
        class="alert-content-wrapper"
        @if($dismissible)
        x-show="show"
        @endif
    >
        <h2 class="alert-title">
            <x-ark-icon :name="alertIcon($type)" class="alert-icon" size="xs" />
            <span>{{ alertTitle($type) }}</span>
            @if($dismissible)
            <button type="button" @click="show = false" aria-label="{{ trans('ui::alert.dismiss') }}">
                <x-ark-icon name="cross" size="xs" aria-hidden="true" focusable="false" />
            </button>
            @endif
        </h2>

        <span class="alert-content">
            @if($message !== null)
                {{ $message }}
            @else
                {{ $slot }}
            @endif
        </span>
    </div>
</div>
