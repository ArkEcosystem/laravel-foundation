@props (['category'])

<span {{ $attributes->class([
    'text-xs font-semibold text-white rounded border border-white px-2 py-1',
    $category->className(),
]) }}>
    {{ $category->label() }}
</span>
