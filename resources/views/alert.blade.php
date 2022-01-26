@props([
    'message'      => null,
    'type'         => \ARKEcosystem\Foundation\UserInterface\Support\Enums\AlertType::INFO,
    'dismissible'  => false,
    'withoutTitle' => false,
])

<div
    {{$attributes->class(['alert-wrapper alert-'.$type])}}
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
        @unless($withoutTitle)
            <h2 class="alert-title">
                <x-ark-icon :name="alertIcon($type)" class="alert-icon" size="xs" />
                <span>{{ alertTitle($type) }}</span>
                @if($dismissible)
                <button type="button" @click="show = false">
                    <x-ark-icon name="cross" size="xs" />
                </button>
                @endif
            </h2>
        @endunless

        <span class="alert-content">
            @if($message !== null)
                {{ $message }}
            @else
                {{ $slot }}
            @endif
        </span>
    </div>
</div>
