@props([
    'nodeName' => null,
    'onClick',
    'iconName',
    'name' => null,
    'tooltip' => null,
])

<div class="{{ $name }} toastui-editor-toolbar-icons border-b border-transparent">
    <button
        type="button"
        class="flex items-center mx-2 h-16 border-b-2 border-transparent hover:border-theme-primary-600 hover:text-theme-primary-600"
        {{ $attributes }}
        @click="{{ $onClick }}"
        @if($nodeName)
            :class="isActive('{{ $nodeName }}') ? 'border-theme-primary-600 text-theme-primary-600' : 'text-theme-secondary-900'"
        @endif
        data-tippy-content="{{ $tooltip ?? trans('ui::markdown.navbar.tooltips.' . $name) }}"
    >
        <x-ark-icon :name="'wysiwyg.' . $iconName" class="inline" size="sm" />
    </button>
</div>
