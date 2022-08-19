@props ([
    'name' => null,
])

@if ($name)
    @error ($name)
        <p {{ $attributes->class('input-help--error') }}>{{ $message }}</p>
    @enderror
@endif
