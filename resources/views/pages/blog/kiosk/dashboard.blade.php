@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/file-download.js')}}"></script>
@endpush

@section('content')
    <x-ark-container>
        <div class="my-8 mx-auto md:w-3/4 lg:w-3/5 xl:w-1/2">
            <h1 class="mx-4 text-2xl font-bold md:text-4xl">Dashboard</h1>
            <div class="mx-4 mt-2 text-theme-secondary-700">Manage your profile and things.</div>

            <div class="flex items-center px-4 mt-5 space-x-4 lg:mt-8">
                <a href="{{ route('kiosk.users') }}" class="button-primary">
                    Users
                </a>

                <a href="{{ route('kiosk.articles') }}" class="button-primary">
                    Articles
                </a>
            </div>

            <div class="px-4 pt-5 mt-5 border-t lg:pt-8 lg:mt-8 border-theme-secondary-200">
                <livewire:profile.two-factor-authentication-form />
            </div>
        </div>
    </x-ark-container>
@endsection
