@extends('layouts.app')

@section('content')
    <x-ark-container>
        <livewire:kiosk-create-article />

        @push('scripts')
            <x-ark-pages-includes-markdown-scripts toolbar="full" />
        @endpush
    </x-ark-container>
@endsection
