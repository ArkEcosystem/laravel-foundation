@props ([
    'articles',
    'article',
])

<section>
    <div class="flex items-center">
        <h3 class="header-2">{{ trans('ui::pages.blog.related', ['category' => $article->category->value]) }}</h3>
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
