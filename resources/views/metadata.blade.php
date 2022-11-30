@props([
    'page'   => 'home',
    'detail' => null,
])

@php
    $metaImage = null;

    if (isset(trans('metatags.'.$page)['dynamicImage'])
        && file_exists(public_path('meta-images/mix-manifest.json'))
        && file_exists(public_path('meta-images/' . trans('metatags.'.$page)['dynamicImage']))
    ) {
        $metaImage = url(mix('meta-images/' . trans('metatags.'.$page)['dynamicImage'], 'meta-images'));
    } else if (isset(trans('metatags.'.$page)['image'])) {
        $metaImage = trans("metatags.{$page}.image", ['detail' => $detail ? Str::camel(Str::slug($detail)) : null]);
    }
@endphp

@section('meta-title')
    @lang("metatags.{$page}.title", ['detail' => $detail])
@endsection

@isset(trans('metatags.'.$page)['description'])
    @section('meta-description')
        @lang("metatags.{$page}.description", ['detail' => $detail])
    @endsection
@endisset


@if($metaImage !== null)
    @section('meta-image')
        {{ $metaImage }}
    @endsection
@endif
