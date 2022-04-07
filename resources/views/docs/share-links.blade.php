<div class="flex items-center space-x-2 font-semibold text-theme-secondary-900">
    <div>@lang('actions.share'):</div>

    <x-ark-social-square :url="ShareLink::reddit()" icon="brands.outline.reddit" />
    <x-ark-social-square :url="ShareLink::twitter()" icon="brands.outline.twitter" />
    <x-ark-social-square :url="ShareLink::facebook()" icon="brands.outline.facebook" />
</div>
