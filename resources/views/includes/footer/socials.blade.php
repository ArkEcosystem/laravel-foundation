<div {{ $attributes->class('space-y-4') }}>
    <h3 class="text-theme-secondary-200">@lang('ui::pages.extended-footer.socials.title')</h3>

    <div>@lang('ui::pages.extended-footer.socials.description')</div>

    <div class="flex mt-6 space-x-2 text-theme-primary-600">
        <x-ark-social-square
            :url="trans('ui::urls.socials.github')"
            icon="app-github"
            class="border-2 border-theme-secondary-800 w-15 h-15"
            hover-class="hover:text-white hover:bg-theme-primary-700 hover:border-theme-primary-700"
            icon-size="w-8 h-8"
        />

        <x-ark-social-square
            :url="trans('ui::urls.socials.twitter')"
            icon="app-twitter"
            class="border-2 border-theme-secondary-800 w-15 h-15"
            hover-class="hover:text-white hover:bg-theme-primary-700 hover:border-theme-primary-700"
            icon-size="w-8 h-8"
        />
    </div>
</div>
