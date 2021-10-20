@props([
    'isArkProduct'  => true,
    'noBorder'      => '',
    'copyClass'     => '',
    'copyText'      => null,
    'socials'       => null,
    'copyrightSlot' => null,
    'privacyPolicyUrl' => null,
    'cookiePolicyUrl' => null,
])

<div class="flex items-center justify-between @unless ($noBorder) border-t border-theme-secondary-800 @endunless">
    <x-ark-footer-copyright
        :is-ark-product="$isArkProduct"
        :copy-text="$copyText"
        :class="$copyClass"
        :copyright-slot="$copyrightSlot"
        :privacyPolicyUrl="$privacyPolicyUrl"
        :cookiePolicyUrl="$cookiePolicyUrl"
    />

    <x-ark-footer-social :networks="$socials" />
</div>
