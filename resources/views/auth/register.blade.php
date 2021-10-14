@extends('layouts.app', ['fullWidth' => true])

<x-ark-metadata page="sign-up" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="ark-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-ark-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.sign_up')],
    ]" />
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
