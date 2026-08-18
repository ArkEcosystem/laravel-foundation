@if ($type === 'success')
    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-theme-success-200">
        <x-ark-icon name="check-mark-small" size="2xs" class="text-theme-success-500" />
    </div>
@elseif ($type === 'failed' || $type === 'error')
    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-theme-danger-100">
        <x-ark-icon name="cross" size="2xs" class="text-theme-danger-500" />
    </div>
@elseif ($type === 'running')
    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-theme-warning-100">
        <x-ark-icon name="arrows.arrows-rotate" size="xs" class="animation-spin text-theme-warning-900" />
    </div>
@elseif ($type === 'updated')
    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-theme-warning-100">
        <x-ark-icon name="arrows.arrows-rotate" size="xs" class="text-theme-warning-900" />
    </div>
@elseif ($type === 'active')
    <div
        class="box-border flex h-4.5 w-4.5 flex-shrink-0 items-center justify-center rounded-full border-2 border-theme-primary-500">
    </div>
@elseif ($type === 'locked')
    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-theme-secondary-300">
        <x-ark-icon name="lock" size="xs" class="text-theme-secondary-700" />
    </div>
@else
    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-theme-secondary-300"></div>
@endif
