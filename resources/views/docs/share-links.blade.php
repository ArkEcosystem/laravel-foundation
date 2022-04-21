<div class="flex items-center space-x-2 font-semibold text-theme-secondary-900">
    <div>@lang('ui::actions.docs.share'):</div>

    <x-ark-social-square
        :url="$document->urlReddit()"
        icon="brands.reddit"
        hoverClass="hover:bg-theme-primary-700 hover:text-white"
    />

    <x-ark-social-square
        :url="$document->urlTwitter()"
        icon="brands.twitter"
        hoverClass="hover:bg-theme-primary-700 hover:text-white"
    />

    <x-ark-social-square
        :url="$document->urlFacebook()"
        icon="brands.facebook"
        hoverClass="hover:bg-theme-primary-700 hover:text-white"
    />
</div>
