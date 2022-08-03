@props ([
    'article',
    'headerGradient' => null,
])

<div class="flex flex-col items-center lg:flex-row lg:space-x-12">
    <div class="flex flex-col lg:w-1/2">
        <div class="flex mb-4 space-x-3 text-sm font-semibold text-theme-secondary-700">
            <span class="pr-3 border-r border-theme-secondary-700">
                {{ $article->created_at->format('jS M Y') }}
            </span>

            <span>
                {{ formatReadTime($article->reading_time) }} @lang('ui::pages.blog.read')
            </span>
        </div>

        <h2 class="header-1">
            <a
                href="{{ $article->url() }}"
                @class([
                    'leading-normal',
                    'text-theme-secondary-200' => empty($headerGradient),
                ])
            >
                @if (! empty($headerGradient))
                    <x-ark-gradient-text
                        :from="$headerGradient[0]"
                        :via="$headerGradient[1]"
                        :to="$headerGradient[2]"
                        animationSpeed="25s"
                        animated
                    >
                        {{ $article->title }}
                    </x-ark-gradient-text>
                @else
                    {{ $article->title }}
                @endif
            </a>
        </h2>

        <div class="flex relative justify-center mt-6 w-full lg:hidden">
            <a href="{{ $article->url() }}">
                <img
                    src="{{ asset($article->banner()) }}"
                    class="w-full h-full"
                />
            </a>
        </div>

        <div class="pt-6 paragraph-description text-theme-secondary-400">
            {{ $article->excerpt(50) }}...
        </div>

        <div class="flex flex-col mt-8 space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3">
            <a href="{{ $article->url() }}" class="button-primary">@lang('ui::actions.read_more')</a>
        </div>
    </div>

    <div class="hidden relative justify-center mt-12 w-full lg:flex lg:mt-0 lg:w-1/2">
        <a href="{{ $article->url() }}">
            <img
                src="{{ asset($article->banner()) }}"
                class="w-full h-full"
            />
        </a>
    </div>
</div>
