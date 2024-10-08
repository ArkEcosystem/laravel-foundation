@props([
    'name',
    'errors',
    'class'          => '',
    'id'             => null,
    'model'          => null,
    'hideLabel'      => false,
    'label'          => null,
    'tooltip'        => null,
    'required'       => false,
    'maxlength'      => null,
    'rows'           => 10,
    'usersInContext' => [],
    'endpoint'       => '/api/users/autocomplete',
    'placeholder'    => '',
    'plainText'      => true,
])

<div
    x-data="UserTagger(
        '{{ $endpoint }}',
        {{ json_encode($usersInContext) }},
        {{ $maxlength === null ? 'null' : $maxlength }},
        {{ $plainText ? 'true' : 'false' }}
    )"
    class="{{ $class }} ark-user-tagger--input"
>
    <div class="input-group">
        @unless ($hideLabel)
            @include('ark::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id ?? $name,
                'label'    => $label,
                'tooltip'  => $tooltip,
                'required' => $required,
            ])
        @endunless

        <div class="input-wrapper" >
            <input
                x-ref="input"
                type="hidden"
                id="{{ $id ?? $name }}"
                wire:model.live="{{ $model ?? $name }}"
                name="{{ $name }}"
            />

            @unless($plainText)
                <div
                    wire:ignore
                    x-ref="editor"
                    style="min-height: {{ $rows * 30 }}px; word-break: break-word; white-space: pre-wrap;"
                    @class([
                        'input-text',
                        'input-text--error' => $errors->has($name),
                    ])
                    data-placeholder="{{ $placeholder }}"
                >{{ $slot ?? '' }}</div>
            @else
                <textarea
                    wire:ignore
                    x-ref="editor"
                    style="min-height: {{ $rows * 30 }}px; word-break: break-word; white-space: pre-wrap;"
                    @class([
                        'input-text',
                        'input-text--error' => $errors->has($name),
                    ])
                    data-placeholder="{{ $placeholder }}"
                >{{ $slot ?? '' }}</textarea>
            @endunless
        </div>

        <x-ark::inputs.input-error :name="$name" />
    </div>
</div>
