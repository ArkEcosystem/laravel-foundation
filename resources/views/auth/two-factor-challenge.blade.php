@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="two-factor.login" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading"/>

    <div x-data="{ recovery: @json($errors->has('recovery_code')) }" x-cloak>
        @include('ark-fortify::auth.two-factor.form')
        @include('ark-fortify::auth.two-factor.recovery-form')
    </div>
@endsection
