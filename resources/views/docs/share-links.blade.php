<div class="flex items-center space-x-2 font-semibold text-theme-secondary-900">
    <div>@lang('ui::actions.docs.share'):</div>

    <x-ark-social-square
        :url="$document->urlReddit()"
        icon="brands.reddit"
    />

    <x-ark-social-square
        :url="$document->urlTwitter()"
        icon="brands.twitter"
    />

    <x-ark-social-square
        :url="$document->urlFacebook()"
        icon="brands.facebook"
    />
</div>
