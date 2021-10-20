@props([
    'isArkProduct'  => true,
    'class'         => '',
    'copyClass'     => '',
    'copyText'      => null,
    'socials'       => null,
    'copyrightSlot' => null,
    'privacyPolicyUrl' => null,
    'cookiePolicyUrl' => null,
])

<div class="flex flex-col {{ $class }}">
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
