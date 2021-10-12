@extends('layouts.app', ['fullWidth' => true])

@section('title')
@lang('ui::metatags.feedback_thank_you')
@endsection

@section('content')

<x-ark-container>
    <div class="flex flex-col items-center mx-auto w-full text-center">
        <x-ark-icon name="fortify-profile.feedback.thank-you" class="w-full h-full" />

        <h1 class="px-8 mt-8 max-w-xs sm:max-w-none">@lang('ui::pages.feedback_thank_you.title')</h1>
        <p class="mt-4 max-w-xs leading-relaxed sm:px-4 sm:max-w-lg lg:px-0 lg:max-w-none">@lang('ui::pages.feedback_thank_you.description')</p>

        <a href="{{ route('home') }}" class="mt-8 w-full sm:w-auto button-secondary">@lang('ui::pages.feedback_thank_you.home_page')</a>
    </div>
</x-ark-container>

@endsection
