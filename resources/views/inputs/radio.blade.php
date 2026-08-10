<div class="{{ $class ?? 'mt-4' }} flex items-center">
    <input id="{{ $id ?? $name }}" name="{{ $name }}" type="radio" class="form-radio input-radio"
        value="{{ $value ?? '' }}" wire:model.live="{{ $model ?? $name }}"
        @if ($checked ?? '') checked @endif @if ($disabled ?? '') disabled @endif />
    <label for="{{ $id ?? $name }}" class="ml-3">
        <span class="block text-sm font-medium leading-5 text-theme-secondary-700">
            {{ $label ?? '' ? $label : trans('forms.' . $name) }}
        </span>
    </label>
</div>
