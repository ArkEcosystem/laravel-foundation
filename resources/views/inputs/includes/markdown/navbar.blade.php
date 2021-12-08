<div class="whitespace-nowrap toastui-editor-toolbar ark-markdown-editor-toolbar">
    <div class="flex items-center mx-4 border-b toastui-editor-toolbar-group border-theme-secondary-200">
        @include('ark::inputs.includes.markdown.button', ['iconName' => 'undo', 'onClick' => 'undo'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'redo', 'onClick' => 'redo'])

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'text-bold', 'onClick' => 'strong', 'nodeName' => 'strong'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'text-italic', 'onClick' => 'emph', 'nodeName' => 'emph'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'text-strike-through', 'onClick' => 'strike', 'nodeName' => 'strike'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'text-underline', 'onClick' => 'underline', 'nodeName' => 'underline'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'open-quote', 'onClick' => 'blockQuote', 'nodeName' => 'blockQuote'])

        @include('ark::inputs.includes.markdown.button-separator')

        @for($i=1; $i<=4; $i++)
            @include('ark::inputs.includes.markdown.button', [
                'iconName' => 'H' . $i,
                'onClick' => 'heading(' . $i . ')',
                'nodeName' => 'heading' . $i,
            ])
        @endfor

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'list-bullets', 'onClick' => 'bulletList', 'nodeName' => 'bulletList'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'list-numbers', 'onClick' => 'orderedList', 'nodeName' => 'orderedList'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'table', 'onClick' => 'table', 'nodeName' => 'table', 'name' => 'table'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'image-file-landscape', 'onClick' => 'image', 'nodeName' => 'image', 'name' => 'image'])

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'hyperlink', 'onClick' => 'link', 'nodeName' => 'link', 'name' => 'link'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'programming-browser-1', 'onClick' => 'code', 'nodeName' => 'code'])

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'programming-browser', 'onClick' => 'codeBlock', 'nodeName' => 'codeBlock'])

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['iconName' => 'image-link', 'onClick' => 'embedLink', 'nodeName' => 'embedLink'])
    </div>
</div>

@push('footer')
    @include('ark::inputs.includes.markdown.embed-link-modal')
@endpush
