<div
    {{ $attributes->merge(['class' => 'avatar-wrapper overflow-hidden ' . $attributes->get('class', 'w-10 h-10 rounded-xl md:h-11 md:w-11')]) }}>
    <div class="h-full w-full object-cover">
        {!! ARKEcosystem\Foundation\UserInterface\Support\Avatar::make(
            $identifier,
            $attributes->get('show-identifier-letters'),
        ) !!}
    </div>
</div>
