<div class="flex items-center space-x-2 font-semibold text-theme-secondary-900">
    <div>@lang('ui::actions.docs.share'):</div>

    <x-ark-social-square :url="ShareLink::reddit()" icon="brands.reddit" />
    <x-ark-social-square :url="ShareLink::twitter()" icon="brands.twitter" />
    <x-ark-social-square :url="ShareLink::facebook()" icon="brands.facebook" />
</div>
