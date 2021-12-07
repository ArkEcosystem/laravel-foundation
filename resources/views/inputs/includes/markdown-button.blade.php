@props([
    'nodeName' => null,
    'onClick',
    'iconName',
])
<button
    type="button"
    class="h-16 mx-2 border-b-2 flex items-center -mt-0.5 -mb-0.5 border-transparent hover:border-theme-primary-600 hover:text-theme-primary-600"
    {{ $attributes }}
    @click="{{ $onClick }}"
    @if($nodeName)
        :class="{'border-theme-primary-600 text-theme-primary-600': isActive('{{ $nodeName }}')}"
    @endif
>
    <x-ark-icon :name="'wysiwyg.' . $iconName" class="inline" size="sm" />
</button>
