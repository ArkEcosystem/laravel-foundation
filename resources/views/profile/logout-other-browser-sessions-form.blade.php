<div dusk="logout-other-browser-sessions">
    <div class="flex flex-col">
        <span class="header-4">@lang('ui::pages.logout-sessions.title')</span>
        <span class="mt-4">@lang('ui::pages.logout-sessions.description')</span>
        <x-ark-alert class="mt-8">
            @lang('ui::pages.logout-sessions.content')
        </x-ark-alert>
    </div>

    @if (count($this->sessions) > 0)
        <div class="hidden mt-8 md:flex">
            <x-ark-tables.table class="w-full">
                <thead>
                    <x-ark-tables.row>
                        <x-ark-tables.header name="ui::pages.logout-sessions.ip" class="text-sm font-semibold"/>
                        <x-ark-tables.header name="ui::pages.logout-sessions.os" class="text-sm font-semibold"/>
                        <x-ark-tables.header name="ui::pages.logout-sessions.browser" class="text-sm font-semibold"/>
                        <x-ark-tables.header name="ui::pages.logout-sessions.last_active" class="text-sm font-semibold text-right"/>
                    </x-ark-tables.row>
                </thead>

                @foreach ($this->sessions as $session)
                    <x-ark-tables.row>

                        <x-ark-tables.cell>
                            @if ($session->agent->isDesktop())
                                <x-ark-icon
                                    name="monitor"
                                    class="{{ $session->is_current_device ? 'text-theme-success-600' : '' }}"
                                />
                            @else
                                <x-ark-icon
                                    name="mobile-phone"
                                    class="{{ $session->is_current_device ? 'text-theme-success-600' : '' }}"
                                />
                            @endif
                            <div class="ml-3">
                                {{ $session->ip_address }}
                            </div>

                        </x-ark-tables.cell>

                        <x-ark-tables.cell>
                            {{ $session->agent->platform() }}
                        </x-ark-tables.cell>

                        <x-ark-tables.cell>
                            {{ $session->agent->browser() }}
                        </x-ark-tables.cell>

                        <x-ark-tables.cell class="text-right">
                            @if ($session->is_current_device)
                                <span class="font-semibold text-theme-success-600">@lang('ui::generic.this_device')</span>
                            @else
                                @lang('ui::generic.last_active') {{ $session->last_active }}
                            @endif
                        </x-ark-tables.cell>

                    </x-ark-tables.row>
                @endforeach
            </x-ark-tables.table>
        </div>

        <div class="mt-4 w-full text-base md:hidden">
            @foreach ($this->sessions as $session)
                <div class="py-4 space-y-3 border-b border-dashed border-theme-secondary-300 dark:border-theme-secondary-800">

                    <div class="flex justify-between">
                        <div class="font-semibold text-theme-secondary-500">
                            @lang('ui::pages.logout-sessions.ip')
                        </div>
                        <div class="flex items-center space-x-3 w-full min-w-0 text-base font-normal text-theme-secondary-700">
                            <div class="ml-4 w-full text-right truncate">
                                {{ $session->ip_address }}
                            </div>
                            @if ($session->agent->isDesktop())
                                <x-ark-icon
                                    name="monitor"
                                    class="{{ $session->is_current_device ? 'text-theme-success-600' : '' }}"
                                />
                            @else
                                <x-ark-icon
                                    name="mobile-phone"
                                    class="{{ $session->is_current_device ? 'text-theme-success-600' : '' }}"
                                />
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div class="font-semibold text-theme-secondary-500">
                            @lang('ui::pages.logout-sessions.os')
                        </div>
                        <div class="text-base font-normal text-theme-secondary-700">
                            {{ $session->agent->platform() }}
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div class="font-semibold text-theme-secondary-500">
                            @lang('ui::pages.logout-sessions.browser')
                        </div>
                        <div class="text-base font-normal text-theme-secondary-700">
                            {{ $session->agent->browser() }}
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div class="font-semibold text-theme-secondary-500">
                            @lang('ui::pages.logout-sessions.last_active')
                        </div>
                        <div class="text-base font-normal text-theme-secondary-700">
                            @if ($session->is_current_device)
                                <span class="font-semibold text-theme-success-600">@lang('ui::generic.this_device')</span>
                            @else
                                @lang('ui::generic.last_active') {{ $session->last_active }}
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
    <div class="flex flex-row justify-end mt-8 md:mt-4">
        <button
            type="submit"
            class="inline-flex justify-center items-center space-x-2 w-full sm:w-auto button-cancel"
            wire:click="confirmLogout"
        >
            <span>@lang('ui::pages.logout-sessions.confirm_logout')</span>
        </button>
    </div>

    @if($this->modalShown)
        <x-ark-modal title-class="header-2" width-class="max-w-2xl" wire-close="closeModal">
            <x-slot name="title">
                @lang('ui::forms.confirming-logout.title')
            </x-slot>

            <x-slot name="description">
                <div class="flex justify-center mt-8 w-full">
                    <x-ark-icon name="fortify-modal.secure" size="h-28" />
                </div>
                <div class="flex flex-col mt-8">
                    <div class="mt-4">
                        @lang('ui::forms.confirming-logout.content')
                    </div>
                </div>
                <form class="mt-8">
                    <div class="space-y-2">
                        <x-ark-input
                            type="password"
                            name="password"
                            model="password"
                            :label="trans('ui::forms.password')"
                        />
                    </div>
                </form>
            </x-slot>

            <x-slot name="buttons">
                <div class="flex flex-col justify-end w-full sm:flex-row sm:space-x-3">
                    <button
                        type="button"
                        dusk="delete-other-browser-sessions-cancel"
                        class="mb-4 sm:mb-0 button-secondary"
                        wire:click="closeModal">
                            @lang('ui::actions.cancel')
                    </button>

                    <button
                        wire:click="logoutOtherBrowserSessions"
                        type="button"
                        dusk="delete-other-browser-sessions"
                        class="inline-flex justify-center items-center button-primary"
                        @unless($this->getErrorBag()->isEmpty()) disabled @endunless
                    >
                        @lang('ui::actions.confirm')
                    </button>
                </div>
            </x-slot>
        </x-ark-modal>
    @endif
</div>
