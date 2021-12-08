@props([
    'nodeName' => null,
    'onClick',
    'iconName',
    // Needed for the buttons that have a popup (table, image, etc) since the
    // editor uses the name to determine the position.
    'name' => '',
])
<div class="{{ $name }} toastui-editor-toolbar-icons">
    <button
        type="button"
        class="flex items-center mx-2 -mt-0.5 -mb-0.5 h-16 border-b-2 border-transparent  hover:border-theme-primary-600 hover:text-theme-primary-600"
        {{ $attributes }}
        @click="{{ $onClick }}"
        @if($nodeName)
            :class="isActive('{{ $nodeName }}') ? 'border-theme-primary-600 text-theme-primary-600' : 'text-theme-secondary-900'"
        @endif
    >
        <x-ark-icon :name="'wysiwyg.' . $iconName" class="inline" size="sm" />
    </button>
</div>
