@props([
    'containerClass' => 'flex flex-col',
])

<div {{ $attributes->except('containerClass') }}>
    <div class="content-container {{ $containerClass }} w-full py-8">
        {{ $slot }}
    </div>
</div>
