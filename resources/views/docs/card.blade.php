<a
    id="{{ $id }}"
    href="{{ $url }}"
    {{ $attributes->class(['p-8 flex flex-col border-2 border-theme-primary-100 rounded-xl hover:border-transparent hover:shadow-xl transition-default'])->except(['title', 'description']) }}
>
    <h3 class="text-lg font-semibold line-clamp-2">{{ $title }}</h3>
    <p class="mt-2 leading-7 line-clamp-2">{{ $description }}</p>
</a>
