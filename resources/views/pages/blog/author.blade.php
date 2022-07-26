@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])
    @section('content')
        <livewire:blog-article-list 
            :request="$request" 
            :author="$author" 
        />
    @endsection
@endcomponent
