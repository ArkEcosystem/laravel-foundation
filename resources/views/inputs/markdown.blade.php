@props([
    'xData' => '{}',
    'name',
    'id' => null,
    'model' => null,
    'class' => '',
    'label' => '',
    'height' => null,
    'toolbar' => 'basic',
    'showCharsCount' => true,
    'showWordsCount' => true,
    'showReadingTime' => true,
    'charsLimit' => false,
])

<div id="markdown-editor-{{ $id ?? $name }}" class="ark-markdown-editor with-line-numbers ark-markdown-editor-{{ $toolbar }} {{ $class ?? '' }}">
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
                    '{{ $id ?? $name }}',
                    @if($height)'{{ $height }}'@else null @endif,
                    '{{ $charsLimit }}',
                    {{ $xData }}
                )"
                class="overflow-hidden bg-white rounded border border-theme-secondary-200 dark:border-theme-secondary-700 dark:bg-theme-secondary-900"
            >

                <div wire:ignore>
                    @include('ark::inputs.includes.markdown.navbar', ['toolbar' => $toolbar])

                    @include('ark::inputs.includes.markdown.navbar', ['toolbar' => $toolbar, 'mobile' => true])
                </div>

                <textarea
                    x-ref="input"
                    style="display: none"
                    id="{{ $id ? $id : $name }}"
                    name="{{ $name }}"
                    wire:model.live="{{ $model ? $model : $name }}"
                ></textarea>

                <div wire:ignore x-ref="editor" class="dark:text-theme-secondary-500"></div>

                @if($showCharsCount || $showWordsCount || $showReadingTime)
                    <div x-cloak class="flex justify-end py-3 text-xs bg-white border-t border-theme-secondary-200 dark:border-theme-secondary-700 dark:bg-theme-secondary-900 dark:text-theme-secondary-500">
                        @if($showWordsCount)
                            <span class="px-4">@lang ('ui::forms.wysiwyg.words'): <strong x-text="wordsCount" x-bind:class="{ 'opacity-75': loadingCharsCount }"></strong></span>
                        @endif
                        @if($showCharsCount)
                            <span class="px-4 border-l-2 border-theme-secondary-200 dark:border-theme-secondary-700">
                                @lang ('ui::forms.wysiwyg.characters'):
                                <strong x-text="charsCount" :class="{ 'text-theme-danger-500': charsLimit < charsCount, 'opacity-75': loadingCharsCount }"></strong>
                                <span x-bind:class="{ 'inline': charsLimit, 'hidden': !charsLimit }">/</span>
                                <strong x-text="charsLimit" :class="{ 'inline': charsLimit, 'hidden': !charsLimit, 'text-theme-danger-500': charsLimit < charsCount, 'opacity-75': loadingCharsCount }"></strong>
                            </span>
                        @endif
                        @if($showReadingTime)
                            <span class="px-4 border-l-2 border-theme-secondary-200 dark:border-theme-secondary-700">@lang ('ui::forms.wysiwyg.reading_time'): <strong><span x-text="readMinutes" x-bind:class="{ 'opacity-75': loadingCharsCount }"></span> @lang ('ui::forms.wysiwyg.min')</strong></span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <x-ark::inputs.input-error :name="$name" />
    </div>
</div>
