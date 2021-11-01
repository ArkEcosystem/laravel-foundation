<div dusk="logout-other-browser-sessions">
    <div class="flex flex-col">
        <span class="header-4">@lang('ui::forms.logout-sessions.title')</span>
        <span class="mt-4">@lang('ui::forms.logout-sessions.description')</span>
        <x-ark-alert class="mt-8">
            @lang('ui::forms.logout-sessions.content')
        </x-ark-alert>
    </div>

    <table class="mt-8 w-full text-left table-auto">
        <thead>
        <tr class="text-sm font-semibold text-theme-secondary-500 border-b border-theme-secondary-300">
            <td>
                <div class="mb-3 border-r border-theme-secondary-300">
                    @lang('ui::forms.logout-sessions.ip')
                </div>
            </td>
            <td>
                <div class="ml-5 mb-3 border-r border-theme-secondary-300">
                    @lang('ui::forms.logout-sessions.os')
                </div>
            </td>
            <td>
                <div class="ml-5 mb-3 border-r border-theme-secondary-300">
                    @lang('ui::forms.logout-sessions.browser')
                </div>
            </td>
            <td>
                <div class="text-right mb-3">
                    @lang('ui::forms.logout-sessions.last_active')
                </div>
            </td>
        </tr>
        </thead>
    </table>
</div>