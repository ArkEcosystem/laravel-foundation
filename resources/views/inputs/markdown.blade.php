@props([
    'xData' => '{}',
    'name',
    'id' => null,
    'model' => null,
    'class' => '',
    'label' => '',
    'height' => null,
    'toolbar' => 'basic',
    'plugins' => null,
    'showCharsCount' => true,
    'showWordsCount' => true,
    'showReadingTime' => true,
    'charsLimit' => false,
])

@php
$icons = [
    'iconBold' => 'text-bold',
    'iconItalic' => 'text-italic',
    'iconStrike' => 'text-strike-through',
    'iconUnderline' => 'text-underline',
    'iconQuote' => 'open-quote',
    'iconUl' => 'list-bullets',
    'iconOl' => 'list-numbers',
    'iconTable' => 'table',
    'iconImage' => 'image-file-landscape',
    'iconLink' => 'hyperlink',
    'iconCode' => 'programming-browser-1',
    'iconCodeblock' => 'programming-browser',
    'iconYoutube' => 'social-video-youtube-clip',
    'iconTwitter' => 'social-media-twitter',
    'iconPodcast' => 'social-music-podcast',
    'iconLinkcollection' => 'app-window-link',
    'iconEmbedLink' => 'image-link',
    'iconReference' => 'page-reference',
    'iconAlert' => 'alert-triangle',
    'iconUndo' => 'undo',
    'iconRedo' => 'redo',
    'iconPreview' => 'monitor',
]
@endphp

<div>

</div>

<div class="ark-markdown-editor ark-markdown-editor-{{ $toolbar }} {{ $class ?? '' }}">
    <div class="input-group">
        @unless ($hideLabel ?? false)
            <label
                for="{{ $id ?? $name }}"
                @class([
                    'input-label',
                    'input-label--error' => $errors->has($name),
                ])
            >
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        @endunless

        <div class="input-wrapper">
            <div
                x-data="MarkdownEditor(
                    @if($height)'{{ $height }}'@else null @endif,
                    '{{ $toolbar }}',
                    '{{ $charsLimit }}',
                    {{ $xData }}
                )"
                x-init="init"
                class="overflow-hidden bg-white rounded border-2 border-theme-secondary-200"
            >

                {{-- <div x-show="showOverlay" class="fixed top-0 left-0 z-50 w-full h-full bg-black bg-opacity-75" style="display: none"></div> --}}

                {{-- <div>
                    @for($i=1; $i<=4; $i++)
                        <template x-ref="iconH{{ $i }}">
                            <x-ark-icon name="wysiwyg.H{{ $i }}" class="inline" />
                        </template>
                    @endfor
                    @foreach($icons as $ref => $iconName)
                        <template x-ref="{{ $ref }}">
                            <x-ark-icon name="wysiwyg.{{ $iconName }}" size="sm" class="inline" />
                        </template>
                    @endforeach
                </div> --}}

                <div>
                    <button type="button" @click="undo" >
                        undo
                    </button>

                    <button type="button" @click="redo" >
                        redo
                    </button>

                    <button type="button" @click="heading(1)"  :class="{'bg-theme-secondary-500': isActive('heading1')}">
                        <x-ark-icon name="wysiwyg.H1" class="inline" />
                    </button>
                    <button type="button" @click="heading(2)" :class="{'bg-theme-secondary-500': isActive('heading2')}">
                        <x-ark-icon name="wysiwyg.H2" class="inline" />
                    </button>
                    <button type="button" @click="heading(3)" :class="{'bg-theme-secondary-500': isActive('heading3')}">
                        <x-ark-icon name="wysiwyg.H3" class="inline" />
                    </button>
                    <button type="button" @click="heading(4)" :class="{'bg-theme-secondary-500': isActive('heading4')}">
                        <x-ark-icon name="wysiwyg.H4" class="inline" />
                    </button>
                    <button type="button" @click="strong" :class="{'bg-theme-secondary-500': isActive('strong')}">
                        <x-ark-icon name="wysiwyg.text-bold" class="inline" />
                    </button>
                    <button type="button" @click="emph" :class="{'bg-theme-secondary-500': isActive('emph')}">
                        <x-ark-icon name="wysiwyg.text-italic" class="inline" />
                    </button>
                </div>

                <textarea
                    x-ref="input"
                    style="display: none"
                    id="{{ $id ? $id : $name }}"
                    name="{{ $name }}"
                    wire:model="{{ $model ? $model : $name }}"
                ></textarea>

                <div wire:ignore x-ref="editor"></div>


                @if($showCharsCount || $showWordsCount || $showReadingTime)
                    <div x-cloak class="flex justify-end py-3 text-xs bg-white border-t-2 border-theme-secondary-200">
                        @if($showWordsCount)
                            <span class="px-4">{{ trans('ui::forms.wysiwyg.words') }}: <strong x-text="wordsCount" x-bind:class="{ 'opacity-75': loadingCharsCount }"></strong></span>
                        @endif
                        @if($showCharsCount)
                            <span class="px-4 border-l-2 border-theme-secondary-200">
                                {{ trans('ui::forms.wysiwyg.characters') }}:
                                <strong x-text="charsCount" :class="{ 'text-theme-danger-500': charsLimit < charsCount, 'opacity-75': loadingCharsCount }"></strong>
                                <span x-bind:class="{ 'inline': charsLimit, 'hidden': !charsLimit }">/</span>
                                <strong x-text="charsLimit" :class="{ 'inline': charsLimit, 'hidden': !charsLimit, 'text-theme-danger-500': charsLimit < charsCount, 'opacity-75': loadingCharsCount }"></strong>
                            </span>
                        @endif
                        @if($showReadingTime)
                            <span class="px-4 border-l-2 border-theme-secondary-200">{{ trans('ui::forms.wysiwyg.reading_time') }}: <strong><span x-text="readMinutes" x-bind:class="{ 'opacity-75': loadingCharsCount }"></span> {{ trans('ui::forms.wysiwyg.min') }}</strong></span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>
