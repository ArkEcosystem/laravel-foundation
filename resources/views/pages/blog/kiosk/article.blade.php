@extends('layouts.app')

@section('content')
    <x-ark-container>
        <livewire:kiosk-update-article :article="$article" />

        @push('scripts')
            <x-ark-pages-includes-markdown-scripts toolbar="full" />
        @endpush
    </x-ark-container>
@endsection
