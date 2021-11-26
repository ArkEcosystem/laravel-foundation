@props([
    'success' => false,
    'info' => false,
    'danger' => false,
    'warning' => false,
    'tooltip' => false,
])
<tr {{ $attributes }}
    @if($danger) data-danger @elseif($warning) data-warning @elseif($info) data-info @elseif($success) data-success @endif
    @if($tooltip) data-tippy-content="{{ $tooltip }}" @endif
>
    {{ $slot }}
</tr>
