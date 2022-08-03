@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    <x-ark-metadata page="author" :detail="$author->name" />

    @section('title', trans('metatags.author.title', ['detail' => $author->name]))

    @section('content')
        <livewire:blog-article-list 
            :request="$request" 
            :author="$author" 
        />
    @endsection

@endcomponent
