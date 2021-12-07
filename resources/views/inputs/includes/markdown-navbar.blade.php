<div class="flex items-center mx-4 whitespace-nowrap border-b border-theme-secondary-200 toastui-editor-toolbar ark-markdown-editor-toolbar">
    <div class="toastui-editor-toolbar-group">
        @include('ark::inputs.includes.markdown-button', ['iconName' => 'undo', 'onClick' => 'undo'])

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'redo', 'onClick' => 'redo'])

        @include('ark::inputs.includes.markdown-button-separator')

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'text-bold', 'onClick' => 'strong', 'nodeName' => 'strong'])

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'text-italic', 'onClick' => 'emph', 'nodeName' => 'emph'])

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'text-strike-through', 'onClick' => 'strike', 'nodeName' => 'strike'])

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'text-underline', 'onClick' => 'underline', 'nodeName' => 'underline'])

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'open-quote', 'onClick' => 'blockQuote', 'nodeName' => 'blockQuote'])

        @include('ark::inputs.includes.markdown-button-separator')

        @for($i=1; $i<=4; $i++)
            @include('ark::inputs.includes.markdown-button', [
                'iconName' => 'H' . $i,
                'onClick' => 'heading(' . $i . ')',
                'nodeName' => 'heading' . $i,
            ])
        @endfor

        @include('ark::inputs.includes.markdown-button-separator')

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'list-bullets', 'onClick' => 'bulletList', 'nodeName' => 'bulletList'])

        @include('ark::inputs.includes.markdown-button', ['iconName' => 'list-numbers', 'onClick' => 'orderedList', 'nodeName' => 'orderedList'])

        {{-- @TODO: definde the nodeName --}}
        @include('ark::inputs.includes.markdown-button', ['iconName' => 'table', 'onClick' => 'table', 'nodeName' => 'blockQuote', 'name' => 'table'])

        {{-- @TODO: definde the nodeName --}}
        @include('ark::inputs.includes.markdown-button', ['iconName' => 'image-file-landscape', 'onClick' => 'image', 'nodeName' => 'blockQuote', 'name' => 'image'])
    </div>
</div>
