@props ([
    'author',
    'count',
])

<div class="flex flex-col sm:flex-row sm:justify-between items-center">
    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-x-4 sm:space-y-0">
        <div class="object-contain overflow-hidden w-15 h-15 rounded-xl">
            @if (! $author->photo())
                <img src="{{ $author->photo() }}" />
            @else
                <x-ark-avatar
                    :identifier="$author->name"
                    class="w-15 h-15"
                    show-identifier-letters
                />
            @endif
        </div>

        <div class="flex flex-col sm:space-y-2">
            <div class="hidden sm:block text-xs font-semibold">
                @lang('ui::pages.blog.author')
            </div>

            <div class="text-2xl text-white font-bold">
                {{ $author->name }}
            </div>
        </div>
    </div>

    <div class="text-xs font-semibold">
        <div class="flex flex-col space-y-2 text-right hidden sm:block">
            <div>
                @lang('ui::pages.blog.articles')
            </div>

            <div class="text-2xl text-white font-bold">
                {{ $count }}
            </div>
        </div>

        <div class="sm:hidden mt-3 text-theme-secondary-500">
            @lang('ui::pages.blog.articles_count', ['count' => $count])
        </div>
    </div>
</div>
