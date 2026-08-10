@props(['article'])

<a href="{{ $article->url() }}" class="focus-indicator flex h-full flex-1">
    <div
        class="transition-default hover:size-increase flex h-full cursor-pointer flex-col overflow-hidden rounded-lg bg-white hover:shadow-lg">
        <div class="relative h-auto">
            <img src="{{ asset($article->banner()) }}" class="h-full w-full" />
        </div>

        <div class="flex flex-1 items-center border-t border-theme-secondary-300 px-8 py-6">
            <div>
                <div class="mb-2 flex space-x-3 text-sm font-semibold text-theme-secondary-500">
                    <div class="border-r border-theme-secondary-200 pr-3">
                        {{ $article->created_at->format('jS M Y') }}
                    </div>
                    <div>
                        {{ formatReadTime($article->reading_time) }} @lang('ui::pages.blog.read')
                    </div>
                </div>

                <h3>{{ $article->title }}</h3>
            </div>
        </div>
    </div>
</a>
