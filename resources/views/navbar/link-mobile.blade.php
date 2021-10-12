@php ($route = route($route, empty($params) ? [] : $params))
@php ($isCurrent = url()->full() === $route)
<div class="flex">
    <a
        href="{{ $route }}"
        @class([
            'navbar-mobile-link',
            'navbar-mobile-link-current' => $isCurrent,
        ])
    >
        @if($icon ?? false)
            <x-ark-icon :name="$icon" size="md" class="mr-4" />
        @endif

        {{ $customIcon ?? false }}

        {{ $name }}
    </a>
</div>
