@component('layouts.app')

    @section('title', trans('metatags.blog.article-title', ['title' => $article->title]))

    @push('scripts')
        {{-- @vite('resources/js/prism.js') --}}
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    @endpush

    @push('metatags')
        <meta property="og:title" content="{{ $article->title }}" />
        <meta property="og:description" content="{{ $article->excerpt(50) }}">
        <meta property="og:image" content="{{ asset($article->banner()) }}" />
    @endpush

    @section('meta-title', $article->title)

    @section('meta-description')
        {!! $article->excerpt(120) !!}
    @endsection

    @section('meta-image', asset($article->banner()))

    @section('content')
        <x-ark-blog.article-content :article="$article" />

        @if ($articles->isNotEmpty())
            <x-ark-container class="bg-theme-secondary-100">
                <x-ark-blog.related-articles
                    :article="$article"
                    :articles="$articles"
                    :has-additional="$hasAdditional ?? false"
                />
            </x-ark-container>
        @endif
    @endsection

@endcomponent
