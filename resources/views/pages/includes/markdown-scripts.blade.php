@props(['toolbar' => 'basic'])

@vite(['resources/js/markdown-editor.js', 'resources/css/markdown-editor.css'])

@unless($toolbar === 'basic')
    @include('ark::inputs.includes.markdown.embed-link-modal')
    @include('ark::inputs.includes.markdown.embed-tweet-modal')
    @include('ark::inputs.includes.markdown.embed-podcast-modal')
    @include('ark::inputs.includes.markdown.link-collection-modal')
    @include('ark::inputs.includes.markdown.alert-modal')
    @include('ark::inputs.includes.markdown.page-reference-modal')
    @include('ark::inputs.includes.markdown.image-modal')
@endunless

@include('ark::inputs.includes.markdown.link-modal')
