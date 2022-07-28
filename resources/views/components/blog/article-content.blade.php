@props (['article'])

<section class="w-full bg-theme-background">
    <div class="flex flex-col justify-between items-center px-8 pt-8 mx-auto max-w-5xl md:flex-row md:px-10 bg-theme-background">
        <div class="flex flex-col text-sm font-semibold text-theme-secondary-500 w-full">
            <div class="flex items-center space-x-2 text-sm font-semibold text-theme-secondary-500">
                <div class="pr-3 border-r border-theme-secondary-800">
                    <a
                        href="{{ route('author', $article->author) }}"
                        class="flex items-center space-x-2 group link link-dark"
                    >
                        <div class="object-contain overflow-hidden w-4 h-4 rounded">
                            <img src="{{ $article->author->photo() }}" />
                        </div>

                        <span class="hidden sm:inline-flex group-hover:text-theme-primary-500">
                            {{ $article->author->name }}
                        </span>
                    </a>
                </div>

                <div class="pr-3 border-r border-theme-secondary-800">
                    {{ $article->created_at->format('jS M Y') }}
                </div>

                <div>
                    {{ formatReadTime($article->reading_time) }} {{ trans('ui::pages.blog.read') }}
                </div>
            </div>

            <h1 class="mt-4" style="margin-bottom: 0">
                <span class="text-theme-secondary-200">{{ $article->title }}</span>
            </h1>
        </div>

        @if (Auth::user())
            <div class="justify-end mt-6 w-full md:mt-0 md:w-auto">
                <a
                    href="{{ route('kiosk.article', $article) }}"
                    class="w-full button-primary"
                >
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
    <div class="py-8 px-8 mx-auto md:px-10 lg:max-w-7xl">
        <div class="flex relative justify-center">
            <img src="{{ asset($article->banner()) }}" class="w-full h-full rounded-xl" />

            @if (config('blog.show_category_badge', false))
                <x-ark-blog.category-badge
                    :category="$article->category"
                    class="absolute top-0 right-0 mt-4 mr-4"
                />
            @endif
        </div>
    </div>
</section>

<section class="px-8 pb-8 mx-auto space-y-8 w-full max-w-5xl md:px-10">
    <article class="article-content documentation-content">
        @markdown ($article->body)
    </article>

    <div class="flex items-center pt-8 space-x-3 font-semibold border-t border-theme-secondary-200 text-theme-secondary-900">
        <div>{{ trans('general.share') }}:</div>

        <div class="flex items-center space-x-2">
            <x-ark-social-square
                :url="$article->shareUrlReddit()"
                icon="brands.reddit"
                hoverClass="hover:bg-theme-primary-700 hover:text-white"
            />

            <x-ark-social-square
                :url="$article->shareUrlTwitter()"
                icon="brands.twitter"
                hoverClass="hover:bg-theme-primary-700 hover:text-white"
            />

            <x-ark-social-square
                :url="$article->shareUrlFacebook()"
                icon="brands.facebook"
                hoverClass="hover:bg-theme-primary-700 hover:text-white"
            />
        </div>
    </div>
</section>
