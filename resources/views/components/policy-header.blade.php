@props([
    'contentClass' => 'flex flex-col items-center text-center lg:space-x-16 contact-header',
    'title'        => null,
    'wrapperClass' => 'bg-theme-secondary-100',
])

<div class="{{ $wrapperClass }}">
    <div class="{{ $contentClass }}">
        <h1>{{ $title }}</h1>
    </div>
</div>