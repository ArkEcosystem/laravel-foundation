<div class="flex-1 px-8 md:px-10">
    @if (Auth::check() && $notificationCount > 0)
        <div class="inline-block w-full py-4 md:py-4" dusk="navigation-notifications">
            @foreach ($currentUser->notifications->take(4) as $notification)
                <a class="group -mx-4 flex rounded-xl px-4 pb-4 pt-6 leading-5 hover:bg-theme-success-50 dark:hover:bg-theme-success-900"
                    dusk="navigation-notification-{{ $loop->index }}"
                    href="{{ $notification->link() ?? $notification->route() }}">
                    <x-hermes-notification-icon :notification="$notification" :type="$notification->data['type']" />

                    <div class="ml-5 flex w-full flex-col space-y-1 overflow-auto">
                        <div class="flex flex-row justify-between">
                            <span
                                class="flex-grow truncate font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">
                                {{ $notification->title() }}
                            </span>

                            <span
                                class="hidden whitespace-nowrap text-sm text-theme-secondary-400 dark:text-theme-secondary-700 md:block md:text-right">
                                {{ $notification->created_at_local->diffForHumans() }}
                            </span>
                        </div>

                        <div
                            class="flex flex-col justify-between dark:text-theme-secondary-500 md:flex-row md:space-x-3">
                            <span class="notification-truncate">
                                @if ($renderAsHtml ?? false)
                                    {!! $notification->content() !!}
                                @else
                                    {{ $notification->content() }}
                                @endif
                            </span>

                            <div class="flex flex-row space-x-4">
                                @if ($notification->hasAction())
                                    <span class="link mt-1 whitespace-nowrap font-semibold md:mt-0">
                                        {{ $notification->linkTitle() }}
                                    </span>
                                @endif

                                <span class="mt-1 block text-sm text-theme-secondary-400 md:hidden">
                                    {{ $notification->created_at_local->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>

                @unless ($loop->last)
                    <span
                        class="block w-full border-b border-dashed border-theme-secondary-200 dark:border-theme-secondary-800"></span>
                @endunless
            @endforeach

            <div class="mt-4 flex w-full flex-row justify-center px-2 pb-6">
                <a href="{{ route('user.notifications') }}" class="button-secondary w-full cursor-pointer">
                    {{ $notificationCount > 4 ? trans('ui::actions.show_all') : trans('ui::actions.open_notifications') }}
                </a>
            </div>
        </div>
    @else
        <div
            class="mt-8 rounded-xl border-2 border-theme-secondary-200 p-6 text-center dark:border-theme-secondary-800">
            <span>@lang('ui::menus.notifications.no_notifications')</span>
        </div>
        <div class="py-8 md:px-8">

            <x-ark-icon name="notification.empty" class="light-dark-icon h-full w-full" />

        </div>
    @endif
</div>
