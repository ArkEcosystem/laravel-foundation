@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    <x-ark-metadata page="blog" />

    @section('title', trans('metatags.home.title'))

    @section('content')
        <livewire:blog-article-list :request="$request" />
    @endsection
@endcomponent
