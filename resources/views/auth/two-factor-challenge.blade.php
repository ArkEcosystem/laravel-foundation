@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="two-factor.login" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.2fa')],
    ]" />
@endsection

@section('content')
    <x:ark-fortify::component-heading :title="trans('ui::auth.two-factor.page_header')" :description="trans('ui::auth.two-factor.page_description')" />

    <div x-data="{ recovery: @json($errors->has('recovery_code')) }" x-cloak>
        @include('ark-fortify::auth.two-factor.form')
        @include('ark-fortify::auth.two-factor.recovery-form')
    </div>
@endsection
