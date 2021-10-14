@extends('layouts.app', ['fullWidth' => true])

@section('title')
@lang('ui::metatags.feedback_thank_you')
@endsection

@section('content')

<x-ark-container>
    <div class="flex flex-col items-center w-full mx-auto text-center">
        <x-ark-icon name="fortify-profile.feedback.thank-you" size="w-auto" />

        <h1 class="max-w-xs px-8 mt-8 sm:max-w-none">@lang('ui::pages.feedback_thank_you.title')</h1>
        <p class="max-w-xs mt-4 leading-relaxed sm:px-4 sm:max-w-lg lg:px-0 lg:max-w-none">@lang('ui::pages.feedback_thank_you.description')</p>

        <a href="{{ route('home') }}" class="w-full mt-8 sm:w-auto button-secondary">@lang('ui::pages.feedback_thank_you.home_page')</a>
    </div>
</x-ark-container>

@endsection
