@props(['article', 'header' => null])

<section class="w-full bg-theme-blog-background">
    <div
        class="mx-auto flex max-w-5xl flex-col items-center justify-between bg-theme-blog-background px-8 pt-8 md:flex-row md:px-10">
        <div class="flex w-full flex-col text-sm font-semibold text-theme-secondary-500">
            <div class="flex items-center space-x-2 text-sm font-semibold text-theme-secondary-500">
                <div class="border-r border-theme-secondary-800 pr-3">
                    <a href="{{ route('author', $article->author) }}"
                        class="link link-dark group flex items-center space-x-2">
                        <div class="h-4 w-4 overflow-hidden rounded object-contain">
                            <img src="{{ $article->author->photo() }}" />
                        </div>

                        <span class="hidden group-hover:text-theme-primary-500 sm:inline-flex">
                            {{ $article->author->name }}
                        </span>
                    </a>
                </div>

                <div class="border-r border-theme-secondary-800 pr-3">
                    {{ $article->created_at->format('jS M Y') }}
                </div>

                <div>
                    {{ formatReadTime($article->reading_time) }} @lang ('ui::pages.blog.read')
                </div>
            </div>

            @if ($header)
                {{ $header }}
            @else
                <h1 class="mt-4" style="margin-bottom: 0">
                    <span class="text-theme-secondary-200">{{ $article->title }}</span>
                </h1>
            @endif
        </div>

        @if (Auth::user())
            <div class="mt-6 w-full justify-end md:mt-0 md:w-auto">
                <a href="{{ route('kiosk.article', $article) }}" class="button-primary w-full">
                    <div class="flex justify-center space-x-2 whitespace-nowrap">
                        <x-ark-icon name="pencil" size="sm" />

                        <span>@lang('ui::actions.edit_article')</span>
                    </div>
                </a>
            </div>
        @endif
    </div>
</section>

<section class="bg-hero-50">
    <div class="mx-auto px-8 py-8 md:px-10 lg:max-w-7xl">
        <div class="relative flex justify-center">
            <img src="{{ asset($article->banner()) }}" class="h-full w-full rounded-xl" />

            @if (config('blog.show_category_badge', false))
                <x-ark-blog.category-badge :category="$article->category" class="absolute right-0 top-0 mr-4 mt-4" />
            @endif
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-5xl space-y-8 px-8 pb-8 md:px-10">
    <article class="article-content documentation-content">
        @markdown ($article->body)
    </article>

    <div
        class="flex items-center space-x-3 border-t border-theme-secondary-200 pt-8 font-semibold text-theme-secondary-900">
        <div>@lang('ui::pages.blog.share'):</div>

        <div class="flex items-center space-x-2">
            <x-ark-social-square :url="$article->shareUrlReddit()" icon="brands.reddit"
                hoverClass="hover:bg-theme-primary-700 hover:text-white" />

            <x-ark-social-square :url="$article->shareUrlTwitter()" icon="brands.twitter"
                hoverClass="hover:bg-theme-primary-700 hover:text-white" />

            <x-ark-social-square :url="$article->shareUrlFacebook()" icon="brands.facebook"
                hoverClass="hover:bg-theme-primary-700 hover:text-white" />
        </div>
    </div>
</section>
