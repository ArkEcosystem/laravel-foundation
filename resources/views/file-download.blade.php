<div x-data="fileDownload()" class="{{ $wrapperClass ?? '' }}">
    <button type="button" class="button-secondary {{ $class ?? '' }} flex items-center"
        @click="save('{{ $filename }}', '{{ $content }}', '{{ $type ?? 'text/plain' }}', '{{ $extension ?? 'txt' }}')">
        <x-ark-icon name="arrows.arrow-down-bracket" size="sm" />

        <span class="ml-2">{{ $title ?? '' ? $title : trans('ui::actions.save') }}</span>
    </button>
</div>
