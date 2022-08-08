@props ([
    'heading',
    'description',
    'image' => null,
    'wrapperClass' => 'max-w-7xl mx-auto px-8 md:px-10 py-8 md:py-12',
    'stacked' => false, // Indicate whether image and text are stacked...
    'inverted' => false, // Indicate that the image is on the left
])

@php
    $generateClassList = fn ($variable, $classList) =>
            $variable instanceof Illuminate\View\ComponentSlot
                        ? $variable->attributes->class($classList)
                        : Arr::toCssClasses($classList)
@endphp

<section {{ $attributes }}>
    <div @class([
        $wrapperClass,
        'flex md:items-center flex-col md:flex-row-reverse' => $inverted && ! $stacked,
        'flex md:items-center flex-col md:flex-row' => ! $inverted && ! $stacked,
    ])>
        <div class="w-full mb-8 md:mb-0 {{ $stacked ? 'sm:text-center' : ($image ? 'md:w-1/2' : 'md:w-full') }}">
            <h2 {{ $generateClassList($heading, 'header-1') }}>{{ $heading }}</h2>

            <div {{ $generateClassList($description, 'mt-4 paragraph-description') }}>
                {{ $description }}
            </div>
        </div>

        @if ($image)
            <div @class([
                'mr-0 md:mr-12' => $inverted && ! $stacked,
                'ml-0 md:ml-12' => ! $inverted && ! $stacked,
                'mt-8 max-w-6xl mx-auto flex items-center justify-center' => $stacked,
                'w-full md:w-1/2 flex justify-center' => ! $stacked,
            ])>
                <img src="{{ $image }}" />
            </div>
        @endif
    </div>
</section>
