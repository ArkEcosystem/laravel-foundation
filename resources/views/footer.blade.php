@props([
    'wrapperClass'  => 'px-8 max-w-7xl md:px-10',
    'backgroundColor' => 'bg-theme-secondary-900',
    'linkClass' => 'underline hover:no-underline transition-default hover:text-theme-secondary-200',
    'name' => null,
    'url' => null,
    'creator' => [], // Needs `url` and `label` to display the "Made by"...
    'arkProduct' => false,
    'reservedRights' => true, // Show "All rights reserved"...
    'policy' => [], // Needs `url` and `label` to display the Privacy Policy link...
    'terms' => [], // Needs `url` and `label` to display the Terms of Service link...
    'socials' => [
        [
            'icon' => 'brands.solid.twitter',
            'url' => trans('ui::urls.twitter')
        ],
        [
            'icon' => 'brands.solid.linkedin',
            'url' => trans('ui::urls.linkedin')
        ],
        [
            'icon' => 'brands.solid.facebook',
            'url' => trans('ui::urls.facebook')
        ],
        [
            'icon' => 'brands.solid.youtube',
            'url' => trans('ui::urls.youtube')
        ],
        [
            'icon' => 'brands.solid.github',
            'url' => trans('ui::urls.github')
        ],
        [
            'icon' => 'brands.solid.telegram',
            'url' => trans('ui::urls.telegram')
        ],
    ],
])

<footer {{ $attributes->class('border-t border-theme-secondary-800')->class($backgroundColor) }}>
    <div class="{{ $wrapperClass }} mx-auto justify-between items-center py-5 space-y-4 lg:flex lg:space-y-0">
        <div class="text-sm font-semibold leading-6 break-words">
            <span>
                {{ date('Y') }}
                &copy;
                @if ($name && ! $url)
                    {{ $name }}
                @elseif ($name && $url)
                    <a href="{{ $url }}" class="transition-default hover:text-theme-secondary-200">{{ $name }}</a>
                @elseif (isset($creator['label']) || is_string($creator))
                    <span>
                        @lang ('ui::pages.footer.made_with_love') <a href="{{ $creator['url'] ?? url('/') }}" class="{{ $linkClass }}">{{ is_string($creator) ? $creator : $creator['label'] }}</a>
                    </span>
                @endif
            </span>

            @if ((is_string($creator) || isset($creator['label'])) && $name)
                <span class="mx-0.5">|</span>
                <span>
                    @lang ('ui::pages.footer.made_with_love') <a href="{{ $creator['url'] ?? url('/') }}" class="{{ $linkClass }}">{{ is_string($creator) ? $creator : $creator['label'] }}</a>
                </span>
            @endif

            @if ($arkProduct)
                <span class="mx-0.5">|</span>
                <div>
                    <x-ark-icon
                        name="networks.ark-square"
                        class="inline-block mr-1 -mt-1 ark-logo-red"
                    />

                    <span>An <a href="https://ark.io" class="{{ $linkClass }}">ARK.io</a> product</span>
                </div>
            @endif

            @if ($reservedRights)
                <span class="mx-0.5">|</span>
                <span>@lang ('ui::pages.footer.rights')</span>
            @endif

            @if (isset($policy['url'], $policy['label']))
                <span class="mx-0.5">|</span>
                <a href="{{ $policy['url'] }}" class="{{ $linkClass }}">{{ $policy['label'] }}</a>
            @endif

            @if (isset($terms['url'], $terms['label']))
                <span class="mx-0.5">|</span>
                <a href="{{ $terms['url'] }}" class="{{ $linkClass }}">{{ $terms['label'] }}</a>
            @endif
        </div>

        @if (count($socials) > 0)
            <nav class="flex space-x-3 leading-6">
                @foreach ($socials as $network)
                    <x-ark-social-link :url="$network['url']" :icon="$network['icon']" data-safe-external />
                @endforeach
            </nav>
        @endif
    </div>
</footer>
