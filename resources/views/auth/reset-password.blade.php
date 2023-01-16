@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="password.reset" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.component-heading" />

    <livewire:auth.reset-password-form :token="request()->route('token')" :email="old('email', request()->email)" />
@endsection
