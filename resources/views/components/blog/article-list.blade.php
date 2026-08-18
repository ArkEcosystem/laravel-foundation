<section>
    @if ($author)
        <section class="bg-theme-blog-background">
            <div class="content-container flex w-full flex-col py-6 md:py-8">
                <x-ark-blog.author-header :author="$author" :count="$this->authorArticleCount" :header-gradient="$headerGradient" />
            </div>
        </section>
    @elseif ($featuredArticle)
        <section class="bg-theme-blog-background">
            <x-ark-container>
                <x-ark-blog.header :article="$featuredArticle" :header-gradient="$headerGradient" />
            </x-ark-container>
        </section>
    @endif

    <section class="bg-theme-secondary-100">
        <x-ark-container>
            <div>
                <div id="article-list" class="sm:initial relative flex items-center justify-between pb-8">
                    <x-ark-blog.sort :disabled="$articles->isEmpty() && $term === ''" />

                    <div
                        class="flex items-center justify-between space-x-8 divide-theme-primary-100 sm:relative sm:justify-end sm:divide-x">
                        <x-ark-blog.search-input name="term" :disabled="$articles->isEmpty() && $term === ''" />

                        @if (config('blog.show_filter'))
                            <div class="sm:pl-4">
                                <x-ark-blog.filter-dropdown name="searchCategories" :search-categories="$searchCategories" :categories="$categories"
                                    :disabled="$articles->isEmpty() && $term === ''" />
                            </div>
                        @endif
                    </div>
                </div>

                <div class="blog-grid">
                    @unless ($articles->isEmpty())
                        @foreach ($articles as $article)
                            <div
                                class="{{ [
                                    'blog-entry-large',
                                    'blog-entry-small-large',
                                    'blog-entry-small',
                                    'blog-entry-large-small',
                                    'blog-entry-small',
                                    'blog-entry-small-large',
                                    'blog-entry-large',
                                    'blog-entry-small',
                                    'blog-entry-small',
                                    'blog-entry-small-large-small',
                                ][$loop->index] }}">
                                <x-ark-blog.blog-entry :article="$article" />
                            </div>
                        @endforeach
                    @else
                        <div class="rounded-lg border border-theme-secondary-300 p-6 text-center text-theme-secondary-700">
                            @if ($author)
                                @if ($term !== '')
                                    @lang('ui::pages.blog.no_author_results')
                                @else
                                    @lang('ui::pages.blog.no_author_articles')
                                @endif
                            @else
                                @if ($term !== '')
                                    @lang('ui::pages.blog.no_results')
                                @else
                                    @lang('ui::pages.blog.no_articles')
                                @endif
                            @endif
                        </div>
                        @endif
                    </div>

                    @if ($articles->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $articles->links('ark::pagination') }}
                        </div>
                    @endif

                    <script>
                        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery(
                            '#article-list', 'header')));
                    </script>
                </div>
            </x-ark-container>
        </section>
    </section>
