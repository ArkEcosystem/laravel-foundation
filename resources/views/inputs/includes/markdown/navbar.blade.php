@props(['mobile' => false, 'toolbar'])

<div
    @class([
        'toastui-editor-toolbar ark-markdown-editor-toolbar ',
        'flex relative flex-col px-4 whitespace-nowrap' => !$mobile,
        'ark-markdown-editor-toolbar-mobile' => $mobile,
    ])
    @if($mobile)
        x-cloak
        x-show="showMobileMenu"
    @endif
>
    <div
        @class([
            'flex items-center toastui-editor-toolbar-group',
            'overflow-hidden z-10 relative' => !$mobile,
            'flex-wrap z-20 bg-white rounded-xl absolute shadow-2xl border-none -mx-4 px-5 py-6 right-0' => $mobile,
        ])

    >
        @include('ark::inputs.includes.markdown.button', ['name' => 'undo', 'iconName' => 'undo', 'onClick' => 'undo'])

        @include('ark::inputs.includes.markdown.button', ['name' => 'redo', 'iconName' => 'redo', 'onClick' => 'redo'])

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['name' => 'bold', 'iconName' => 'text-bold', 'onClick' => 'strong', 'nodeName' => 'strong'])

        @include('ark::inputs.includes.markdown.button', ['name' => 'italic', 'iconName' => 'text-italic', 'onClick' => 'emph', 'nodeName' => 'emph'])

        @unless ($toolbar === 'basic')
            @include('ark::inputs.includes.markdown.button', ['name' => 'strike', 'iconName' => 'text-strike-through', 'onClick' => 'strike', 'nodeName' => 'strike'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'underline', 'iconName' => 'text-underline', 'onClick' => 'underline', 'nodeName' => 'underline'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'blockquote', 'iconName' => 'open-quote', 'onClick' => 'blockQuote', 'nodeName' => 'blockQuote'])

            @include('ark::inputs.includes.markdown.button-separator')

            @for($i=1; $i<=4; $i++)
                @include('ark::inputs.includes.markdown.button', [
                    'tooltip' =>  trans('ui::markdown.navbar.tooltips.heading', ['level' => $i]),
                    'iconName' => 'H' . $i,
                    'onClick' => 'heading(' . $i . ')',
                    'nodeName' => 'heading' . $i,
                ])
            @endfor
        @endunless

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['name' => 'ordered_list', 'iconName' => 'list-bullets', 'onClick' => 'bulletList', 'nodeName' => 'bulletList'])

        @include('ark::inputs.includes.markdown.button', ['name' => 'unordered_list', 'iconName' => 'list-numbers', 'onClick' => 'orderedList', 'nodeName' => 'orderedList'])

        @unless ($toolbar === 'basic')
            @include('ark::inputs.includes.markdown.button', ['name' => 'table', 'iconName' => 'table', 'onClick' => 'table', 'nodeName' => 'table'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'image', 'iconName' => 'image-file-landscape', 'onClick' => 'image'])
        @endunless

        @include('ark::inputs.includes.markdown.button-separator')

        @include('ark::inputs.includes.markdown.button', ['name' => 'link', 'iconName' => 'hyperlink', 'onClick' => 'link', 'nodeName' => 'link'])

        @unless ($toolbar === 'basic')
            @include('ark::inputs.includes.markdown.button', ['name' => 'inline_code', 'iconName' => 'programming-browser-1', 'onClick' => 'code', 'nodeName' => 'code'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'code_block', 'iconName' => 'programming-browser', 'onClick' => 'codeBlock', 'nodeName' => 'codeBlock'])

            @include('ark::inputs.includes.markdown.button-separator')

            @include('ark::inputs.includes.markdown.button', ['name' => 'embed_link', 'iconName' => 'image-link', 'onClick' => 'embedLink'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'embed_tweet', 'iconName' => 'social-media-twitter', 'onClick' => 'embedTweet'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'simplecast', 'iconName' => 'social-music-podcast', 'onClick' => 'embedPodcast'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'link_collection', 'iconName' => 'app-window-link', 'onClick' => 'linkCollection'])

            @include('ark::inputs.includes.markdown.button-separator')

            @include('ark::inputs.includes.markdown.button', ['name' => 'alert', 'iconName' => 'alert-triangle', 'onClick' => 'alertModal'])

            @include('ark::inputs.includes.markdown.button', ['name' => 'page_reference', 'iconName' => 'page-reference', 'onClick' => 'pageReference'])
        @endunless

        @unless ($mobile)
            <div class="flex items-center ml-auto markdown-navbar-more" style="display: none">
                <span class="mx-2 h-5 border-l border-theme-secondary-200"></span>

                <button
                    type="button"
                    @click="toggleMobileMenu"
                    :class="{
                        'border-transparent flex hover:text-theme-primary-600 items-center mr-2 p-2 rounded': true,
                        'text-theme-primary-600': showMobileMenu,
                        'text-theme-secondary-700': !showMobileMenu,
                    }"
                    data-tippy-content="{{ $tooltip ?? trans('ui::markdown.navbar.tooltips.more') }}"
                    data-tippy-offset="[0,-15]"
                >
                    <x-ark-icon name="chevron-down" class="inline" size="2xs" />
                </button>
            </div>
        @endunless
    </div>

    @unless ($mobile)
        <span class="block relative z-0 -mt-0.5 h-0 border-b border-theme-secondary-200"></span>
    @endunless
</div>
