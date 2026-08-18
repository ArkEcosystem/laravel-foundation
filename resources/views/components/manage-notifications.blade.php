<div>
    <h1 class="px-6 text-2xl font-bold md:text-4xl">@lang('ui::pages.notifications.page_title')</h1>

    <div class="flex flex-col">
        <div class="mb-2 mt-4 flex w-full flex-row justify-between text-base font-semibold sm:px-6">
            <div class="relative flex flex-row space-x-2 sm:static">
                <div class="relative">
                    <button type="button"
                        class="flex h-10 w-10 cursor-pointer items-center justify-center rounded border border-solid border-theme-secondary-200 text-theme-secondary-400 hover:text-theme-primary-500 focus:outline-none dark:border-theme-secondary-800"
                        wire:click="{{ $this->hasAllSelected ? 'deselectAllNotifications' : 'selectAllNotifications' }}">
                        @if ($this->hasAllSelected)
                            <div
                                class="flex h-5 w-5 items-center justify-center rounded bg-theme-success-600 text-white">
                                <x-ark-icon name="check-mark-bold" size="2xs" />
                            </div>
                        @else
                            <span
                                class="block h-5 w-5 rounded border-2 border-theme-secondary-300 text-white dark:border-theme-secondary-800"></span>
                        @endif
                    </button>
                </div>

                <div class="relative">
                    <x-ark-dropdown wrapper-class="inline-block" dropdown-classes="mt-3"
                        button-class="flex justify-center items-center p-4 h-10 dropdown-button-outline dark:border-theme-secondary-800">
                        @slot('button')
                            <div class="inline-flex w-full items-center justify-center space-x-2">
                                <span
                                    class="w-full text-left font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">
                                    {{ ucfirst($this->activeFilter) }}
                                </span>

                                <x-ark-chevron-toggle is-open="dropdownOpen" class="text-theme-primary-600" />
                            </div>
                        @endslot
                        <div class="py-3">
                            @foreach ($this->getAvailableFilters() as $filter)
                                <button type="button" class="dropdown-entry cursor-pointer focus-visible:ring-inset"
                                    wire:click="$set('activeFilter', '{{ $filter }}')">
                                    @lang("ui::menus.notifications-dropdown.{$filter}")
                                </button>
                            @endforeach
                        </div>
                    </x-ark-dropdown>
                </div>

                <div class="w-10 sm:relative">
                    <x-ark-dropdown wrapper-class="inline-block top-0 right-0 text-left sm:absolute"
                        dropdown-classes="left-0 w-64 mt-3"
                        button-class="flex justify-center w-10 h-10 rounded bg-theme-primary-100 text-theme-primary-600 dark:bg-theme-secondary-800 dark:text-theme-secondary-200">
                        <div class="py-3">
                            <button type="button" class="dropdown-entry cursor-pointer focus-visible:ring-inset"
                                wire:click="markSelectedAsRead">
                                @lang('ui::menus.notifications-dropdown.mark_selected_as_read')
                            </button>

                            <button type="button" class="dropdown-entry cursor-pointer focus-visible:ring-inset"
                                wire:click="markSelectedAsUnread">
                                @lang('ui::menus.notifications-dropdown.mark_selected_as_unread')
                            </button>

                            <button type="button" class="dropdown-entry cursor-pointer focus-visible:ring-inset"
                                wire:click="markSelectedAsStarred">
                                @lang('ui::menus.notifications-dropdown.mark_selected_as_starred')
                            </button>

                            <button type="button" class="dropdown-entry cursor-pointer focus-visible:ring-inset"
                                wire:click="markSelectedAsUnstarred">
                                @lang('ui::menus.notifications-dropdown.unstar_selected')
                            </button>

                            <button type="button" class="dropdown-entry cursor-pointer focus-visible:ring-inset"
                                wire:click="deleteSelected">
                                @lang('ui::menus.notifications-dropdown.mark_selected_as_delete')
                            </button>
                        </div>
                    </x-ark-dropdown>
                </div>
            </div>
            @if ($notificationCount > 0)
                <button type="button" class="link hidden cursor-pointer items-center justify-end sm:flex"
                    wire:click="markAllAsRead">
                    @lang('ui::actions.mark_all_as_read')
                </button>
            @endif
        </div>

        @if ($notificationCount > 0)
            <button type="button" class="link mt-2 flex items-center sm:hidden" wire:click="markAllAsRead">
                @lang('ui::actions.mark_all_as_read')
            </button>
        @endif

        @if ($notificationCount > 0 && $this->notifications->count() > 0)
            @foreach ($this->notifications as $notification)
                <div class="-mx-4 pt-2 sm:mx-0">
                    <div role="button"
                        class="{{ $this->getStateColor($notification) }} flex cursor-pointer flex-col space-y-4 rounded-xl px-6 py-5 sm:flex-row sm:space-x-4 sm:space-y-0"
                        wire:click="$dispatch('markAsRead', '{{ $notification->id }}')">
                        <div class="flex flex-shrink-0 justify-between">
                            @if ($this->isNotificationSelected($notification->id))
                                <button type="button"
                                    wire:click.stop="$dispatch('setNotification', '{{ $notification->id }}')"
                                    class="box-border flex h-5 w-5 cursor-pointer items-center justify-center rounded bg-theme-success-600 text-white">
                                    <x-ark-icon name="check-mark-bold" size="2xs" />
                                </button>
                            @else
                                <button type="button" @class([
                                    'block w-5 h-5 text-white rounded border-2 border-theme-secondary-300',
                                    'dark:border-theme-secondary-600' => $notification->unread(),
                                    'dark:border-theme-secondary-800' => !$notification->unread(),
                                ])
                                    wire:click.stop="$dispatch('setNotification', '{{ $notification->id }}')"></button>
                            @endif

                            <div class="flex items-center space-x-2 sm:hidden">
                                <span class="whitespace-nowrap text-xs text-theme-secondary-500">
                                    {{ $notification->created_at_local->diffForHumans() }}
                                </span>

                                <button type="button" wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                    class="cursor-pointer text-theme-primary-300 hover:text-theme-primary-500 focus-visible:rounded dark:text-theme-secondary-600 dark:hover:text-theme-secondary-400">
                                    <x-ark-icon name="trash" size="sm" />
                                </button>
                            </div>
                        </div>
                        <div class="flex w-full justify-between">
                            <div class="flex w-full flex-row space-x-4">
                                <div class="flex">
                                    <x-hermes-notification-icon :notification="$notification" :type="$notification->data['type']" :state-color="$this->getStateColor($notification)" />
                                </div>

                                <div class="w-full min-w-0 flex-col space-y-1">
                                    <div class="flex justify-between space-x-3">
                                        <div class="block space-x-3">
                                            <span
                                                class="mb-0 text-lg font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">{{ $notification->name() }}</span>
                                            @if ($notification->is_starred)
                                                <button type="button"
                                                    class="transition-default focus-visible:rounded sm:mr-2"
                                                    wire:click.stop="$dispatch('markAsUnstarred', '{{ $notification->id }}')">
                                                    <x-ark-icon name="star-filled" size="sm"
                                                        class="text-theme-warning-200" />
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="transition-default focus-visible:rounded sm:mr-2"
                                                    wire:click.stop="$dispatch('markAsStarred', '{{ $notification->id }}')">
                                                    <x-ark-icon name="star" size="sm"
                                                        class="text-theme-secondary-300" />
                                                </button>
                                            @endif
                                        </div>

                                        <div class="hidden items-start space-x-2 sm:flex">
                                            <span class="whitespace-nowrap text-xs text-theme-secondary-500">
                                                {{ $notification->created_at_local->diffForHumans() }}
                                            </span>

                                            <button type="button"
                                                wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                                class="cursor-pointer text-theme-primary-300 hover:text-theme-primary-500 focus-visible:rounded dark:text-theme-secondary-600 dark:hover:text-theme-secondary-400">
                                                <x-ark-icon name="trash" size="sm" />
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="text-base leading-7 text-theme-secondary-700 dark:text-theme-secondary-500">
                                        <div class="flex flex-col sm:block">
                                            @if ($renderAsHtml)
                                                <span class="break-words">{!! $notification->content() !!}</span>
                                            @else
                                                <span class="break-words">{{ $notification->excerpt() }}</span>
                                            @endif

                                            @if ($notification->hasAction())
                                                <a href="{{ $notification->link() }}" class="link font-semibold">
                                                    {{ $notification->linkTitle() }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (!$loop->last)
                    <div class="sm:px-10">
                        <hr
                            class="mt-2 border-b border-dashed border-theme-secondary-200 dark:border-theme-secondary-800" />
                    </div>
                @endif
            @endforeach

            @if ($notificationCount > $this->notifications->perPage())
                <div class="mt-5 flex justify-center">
                    {{ $this->notifications->links('vendor.ark.pagination') }}
                </div>
            @endif
        @else
            <div
                class="mt-5 flex cursor-pointer flex-col items-center justify-between space-y-2 rounded border-2 border-theme-secondary-200 p-4 dark:border-theme-secondary-800 sm:flex-row sm:space-y-0">
                <span class="p-3">
                    @if (ARKEcosystem\Foundation\Hermes\Enums\NotificationFilterEnum::isAll($this->activeFilter))
                        @lang('ui::menus.notifications.no_notifications')
                    @else
                        @lang('ui::menus.notifications.no_filtered_notifications', ['filter' => $this->activeFilter])
                    @endif
                </span>

                @if (!ARKEcosystem\Foundation\Hermes\Enums\NotificationFilterEnum::isAll($this->activeFilter))
                    <button type="button" wire:click="applyFilter('')"
                        class="button-secondary flex items-center space-x-2 whitespace-nowrap">
                        <x-ark-icon name="arrows.arrow-rotate-left" />

                        <span>@lang('ui::actions.reset_filters')</span>
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
