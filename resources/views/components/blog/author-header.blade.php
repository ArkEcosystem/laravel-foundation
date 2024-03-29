@props ([
    'author',
    'count',
    'headerGradient' => null,
])

<div class="flex flex-col items-center sm:flex-row sm:justify-between">
    <div class="flex flex-col items-center space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
        <div class="object-contain overflow-hidden rounded-xl w-15 h-15">
            @if ($author->photo())
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
            <div class="hidden text-xs font-semibold sm:block">
                @lang('ui::pages.blog.author')
            </div>

            <div @class([
                'text-2xl font-bold',
                'text-white' => empty($headerGradient),
            ])>
                @if (! empty($headerGradient))
                    <x-ark-gradient-text
                        :from="$headerGradient[0]"
                        :via="$headerGradient[1]"
                        :to="$headerGradient[2]"
                        animationSpeed="25s"
                        animated
                    >
                        {{ $author->name }}
                    </x-ark-gradient-text>
                @else
                    {{ $author->name }}
                @endif
            </div>
        </div>
    </div>

    <div class="font-semibold">
        <div class="flex hidden flex-col space-y-2 text-right sm:block">
            <div class="text-xs">
                @lang('ui::pages.blog.articles')
            </div>

            <div class="text-2xl font-bold text-white">
                {{ $count }}
            </div>
        </div>

        <div class="mt-3 text-sm sm:hidden text-theme-secondary-500">
            @lang('ui::pages.blog.articles_count', ['count' => $count])
        </div>
    </div>
</div>
