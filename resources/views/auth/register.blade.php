@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="sign-up" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

    <livewire:auth.register-form />

    <div class="text-center">
        <div class="mb-8">
            @lang('ui::auth.register-form.already_member', ['route' => route('login')])
        </div>
    </div>
@endsection
