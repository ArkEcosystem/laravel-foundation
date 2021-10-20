@props([
    'isArkProduct'  => true,
    'copyText'      => 'ARK.io | ' . trans('ui::general.all_rights_reserved'),
    'copyrightSlot' => null,
    'privacyPolicyUrl' => null,
    'cookiePolicyUrl' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col py-6 space-y-2 font-semibold text-sm text-theme-secondary-700 sm:flex-row sm:space-y-0 sm:space-x-1'])}}>
    <span class="whitespace-nowrap">
        {{ date('Y') }} &copy; {{ $copyText }}
        @if ($privacyPolicyUrl) <br class="sm:hidden"> <span class="hidden sm:inline">| </span><a class="underline" href="{{ $privacyPolicyUrl }}">@lang('ui::general.privacy_policy')</a> @endif
        @if ($cookiePolicyUrl) | <a class="underline" href="{{ $cookiePolicyUrl }}">@lang('ui::general.cookie_policy')</a> @endif
    </span>

    @if($isArkProduct || $copyrightSlot !== null)
        <div class="flex">
            @if($isArkProduct)
                <div>
                    <span class="hidden mr-1 sm:inline"> | </span>
                    <span class="whitespace-nowrap">
                        <x-ark-icon
                            name="ark-logo-red-square"
                            class="inline-block mr-1 -mt-1"
                        />

                        An <a href="https://ark.io/" class="underline hover:no-underline focus-visible:rounded">ARK.io</a> Product
                    </span>
                </div>
            @endif

            {{ $copyrightSlot }}
        </div>
    @endif
</div>
