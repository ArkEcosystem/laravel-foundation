@extends('errors::layout', ['code' => 403])

@section('heading', trans('ui::errors.403_heading'))

@section('message', $exception->getMessage() ?: trans('ui::errors.403_message'))
