@props ([
    'articles',
    'article',
    'hasAdditional' => false,
])

<section>
    <div class="flex justify-between items-center">
        <h3 class="header-2">@lang ('ui::pages.blog.related', ['category' => $article->category->value])</h3>

        @if ($hasAdditional)
            <a href="{{ route('blog', ['category' => $article->category->value]) }}" class="flex items-center space-x-2 font-semibold link">
                <span>@lang('ui::pages.blog.view_all')</span>
                <x-ark-icon name="arrows.chevron-right-small" size="xs" />
            </a>
        @endif
    </div>

    <div class="mt-6 footer-article-list">
        @foreach ($articles as $article)
            @if ($loop->index === 2)
                <div class="hidden xl:block">
                    <x-ark-blog.related-article-entry :article="$article" />
                </div>
            @else
                <x-ark-blog.related-article-entry :article="$article" />
            @endif
        @endforeach

        @if ($articles->count() <= 2)
            <x-ark-blog.placeholder-article-entry />
        @endif

        @if ($articles->count() <= 1)
            <x-ark-blog.placeholder-article-entry />
        @endif
    </div>
</section>
