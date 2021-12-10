@props([
    'nodeName' => null,
    'onClick',
    'iconName',
    'name' => null,
    'tooltip' => null,
])

<div
    class="{{ $name }} toastui-editor-toolbar-icons border-b border-transparent markdown-navbar-item"
    @if ($mobile)
        style="display: none"
    @endif
    @click="showMobileMenu=false"
>
    <button
        type="button"
        @class([
            'flex items-center  hover:text-theme-primary-600' => true,
            'p-2 my-1' => $mobile,
            'mx-2 h-16 border-b-2 border-transparent hover:border-theme-primary-600' => !$mobile,
        ])
        {{ $attributes }}
        @click="{{ $onClick }}"
        @if($nodeName)
            :class="isActive('{{ $nodeName }}') ? 'border-theme-primary-600 text-theme-primary-600' : 'text-theme-secondary-900'"
        @endif
        data-tippy-content="{{ $tooltip ?? trans('ui::markdown.navbar.tooltips.' . $name) }}"
        data-tippy-offset="[0,-15]"
    >
        <x-ark-icon :name="'wysiwyg.' . $iconName" class="inline" />
    </button>
</div>
