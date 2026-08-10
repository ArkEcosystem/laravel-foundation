@props(['notification', 'type' => '', 'relatable' => null, 'stateColor' => 'bg-white dark:bg-theme-secondary-900'])

@php
    $relatable = $relatable ?? $notification->relatable;
    $media = optional($relatable)->logo();
    $identifier = optional($relatable)->fallbackIdentifier();
    $defaultLogo = $notification->logo();
@endphp

<div class="avatar-wrapper pointer-events-none relative inline-block">
    <div class="relative h-11 w-11">
        @if ($media && $media->hasResponsiveImages())
            {{ $media->img('', ['class' => 'absolute object-cover w-full h-full rounded-xl']) }}
        @elseif($media)
            <img src="{{ $media->getUrl() }}" class="absolute h-full w-full rounded-xl object-cover" alt="" />
        @elseif($identifier)
            <x-ark-avatar :identifier="$identifier" class="absolute h-full w-full rounded-xl object-cover" />
        @elseif($defaultLogo)
            <img class="rounded-xl object-cover" src="{{ $defaultLogo }}" alt="" />
        @else
            <div class="h-11 w-11 border border-theme-secondary-200"></div>
        @endif

        <div class="absolute right-0 top-0 -m-4 flex items-center justify-center rounded-full text-transparent">
            <div
                class="{{ $stateColor }} flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full group-hover:bg-theme-success-50 dark:group-hover:bg-theme-success-900">
                @if ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::DANGER)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-danger-50 text-theme-danger-400 dark:bg-theme-danger-400 dark:text-white">
                        <x-ark-icon name="circle.cross" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::SUCCESS)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-success-50 text-theme-success-600 dark:bg-theme-success-600 dark:text-white">
                        <x-ark-icon name="circle.plus" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::WARNING)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-warning-50 text-theme-warning-600 dark:bg-theme-warning-600 dark:text-white">
                        <x-ark-icon name="circle.min" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::BLOCKED)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-secondary-200 text-theme-secondary-900 dark:bg-theme-secondary-700 dark:text-white">
                        <x-ark-icon name="ban" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::COMMENT)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-secondary-200 text-theme-secondary-900 dark:bg-theme-secondary-700 dark:text-white">
                        <x-ark-icon name="message-empty" size="xs" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::MENTION)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-secondary-200 text-theme-secondary-900 dark:bg-theme-secondary-700 dark:text-white">
                        <x-ark-icon name="at" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::ANNOUNCEMENT)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-warning-50 text-theme-warning-600 dark:bg-theme-warning-600 dark:text-white">
                        <x-ark-icon name="bell" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::VIDEO)
                    <div
                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-theme-secondary-200 text-theme-secondary-900 dark:bg-theme-secondary-700 dark:text-white">
                        <x-ark-icon name="play" size="xs" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
