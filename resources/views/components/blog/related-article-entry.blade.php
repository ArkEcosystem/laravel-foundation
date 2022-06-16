@props (['article'])

<a href="{{ $article->url() }}" class="flex flex-1 h-full focus-indicator">
    <div class="flex overflow-hidden flex-col h-full bg-white rounded-lg cursor-pointer hover:shadow-lg transition-default hover:size-increase">
        <div class="relative h-auto">
            <img src="{{ asset($article->banner()) }}" class="w-full h-full" />
        </div>

        <div class="flex flex-1 items-center py-6 px-8 border-t border-theme-secondary-300">
            <div>
                <div class="flex mb-2 space-x-3 text-sm font-semibold text-theme-secondary-500">
                    <div class="pr-3 border-r border-theme-secondary-200">
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
