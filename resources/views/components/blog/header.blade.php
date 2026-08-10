@props(['article', 'headerGradient' => null])

<div class="flex flex-col items-center lg:flex-row lg:space-x-12">
    <div class="flex flex-col lg:w-1/2">
        <div class="mb-4 flex space-x-3 text-sm font-semibold text-theme-secondary-700">
            <span class="border-r border-theme-secondary-700 pr-3">
                {{ $article->created_at->format('jS M Y') }}
            </span>

            <span>
                {{ formatReadTime($article->reading_time) }} @lang('ui::pages.blog.read')
            </span>
        </div>

        <h2 class="header-1">
            <a href="{{ $article->url() }}" @class([
                'leading-normal',
                'text-theme-secondary-200' => empty($headerGradient),
            ])>
                @if (!empty($headerGradient))
                    <x-ark-gradient-text :from="$headerGradient[0]" :via="$headerGradient[1]" :to="$headerGradient[2]" animationSpeed="25s"
                        animated>
                        {{ $article->title }}
                    </x-ark-gradient-text>
                @else
                    {{ $article->title }}
                @endif
            </a>
        </h2>

        <div class="relative mt-6 flex w-full justify-center lg:hidden">
            <a href="{{ $article->url() }}">
                <img src="{{ asset($article->banner()) }}" class="h-full w-full" />
            </a>
        </div>

        <div class="paragraph-description pt-6 text-theme-secondary-400">
            {{ $article->excerpt(50) }}...
        </div>

        <div class="mt-8 flex flex-col space-y-3 sm:flex-row sm:space-x-3 sm:space-y-0">
            <a href="{{ $article->url() }}" class="button-primary">@lang('ui::actions.read_more')</a>
        </div>
    </div>

    <div class="relative mt-12 hidden w-full justify-center lg:mt-0 lg:flex lg:w-1/2">
        <a href="{{ $article->url() }}">
            <img src="{{ asset($article->banner()) }}" class="h-full w-full" />
        </a>
    </div>
</div>
