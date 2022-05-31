@props([
    'notification',
    'type'       => '',
    'relatable'  => null,
    'stateColor' => 'bg-white dark:bg-theme-secondary-900',
])

@php
    $relatable = $relatable ?? $notification->relatable;
    $media = optional($relatable)->logo();
    $identifier = optional($relatable)->fallbackIdentifier();
    $defaultLogo =  $notification->logo();
@endphp

<div class="inline-block relative pointer-events-none avatar-wrapper">
    <div class="relative w-11 h-11">
            @if($media && $media->hasResponsiveImages())
                {{ $media->img('', ['class' => 'absolute object-cover w-full h-full rounded-xl']) }}
            @elseif($media)
                <img src="{{ $media->getUrl() }}" class="object-cover absolute w-full h-full rounded-xl" alt="" />
            @elseif($identifier)
                <x-ark-avatar :identifier="$identifier" class="object-cover absolute w-full h-full rounded-xl" />
            @elseif($defaultLogo)
                <img class="object-cover rounded-xl" src="{{ $defaultLogo }}" alt="" />
            @else
                <div class="w-11 h-11 border border-theme-secondary-200"></div>
            @endif

        <div class="flex absolute top-0 right-0 justify-center items-center -m-4 text-transparent rounded-full">
            <div class="flex flex-shrink-0 items-center justify-center rounded-full h-8 w-8 {{ $stateColor }} group-hover:bg-theme-success-50 dark:group-hover:bg-theme-success-900">
                @if ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::DANGER)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-danger-400 bg-theme-danger-50 dark:bg-theme-danger-400">
                        <x-ark-icon name="circle.cross" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::SUCCESS)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-success-600 bg-theme-success-50 dark:bg-theme-success-600">
                        <x-ark-icon name="circle.plus" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::WARNING)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-warning-600 bg-theme-warning-50 dark:bg-theme-warning-600">
                        <x-ark-icon name="circle.min" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::BLOCKED)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-secondary-900 bg-theme-secondary-200 dark:bg-theme-secondary-700">
                        <x-ark-icon name="ban" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::COMMENT)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-secondary-900 bg-theme-secondary-200 dark:bg-theme-secondary-700">
                        <x-ark-icon name="message-empty" size="xs" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::MENTION)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-secondary-900 bg-theme-secondary-200 dark:bg-theme-secondary-700">
                        <x-ark-icon name="at" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::ANNOUNCEMENT)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-warning-600 bg-theme-warning-50 dark:bg-theme-warning-600">
                        <x-ark-icon name="bell" size="sm" />
                    </div>
                @elseif ($type === ARKEcosystem\Foundation\Hermes\Enums\NotificationTypeEnum::VIDEO)
                    <div class="flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full dark:text-white text-theme-secondary-900 bg-theme-secondary-200 dark:bg-theme-secondary-700">
                        <x-ark-icon name="play" size="xs" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
