@props([
    'wrapperClass'  => 'px-8 max-w-7xl flex md:px-10',
    'copyClass'     => '',
    'border'        => false,
    'copyText'      => null,
    'isArkProduct'  => true,
    'socials'       => null,
    'copyrightSlot' => null,
])

<div {{ $attributes->merge(['class' => 'border-t bg-theme-secondary-900 border-theme-secondary-800']) }}>
    <div class="{{ $wrapperClass }} flex-col mx-auto">
        <div class="flex flex-col items-start lg:flex-row lg:items-center justify-between space-y-3 lg:space-y-0 py-5 @if ($border) border-t border-theme-secondary-800 @endunless">
            <x-ark-footer-copyright
                :is-ark-product="$isArkProduct"
                :copy-text="$copyText"
                :class="$copyClass"
                :copyright-slot="$copyrightSlot"
            />

            <x-ark-footer-social :networks="$socials" />
        </div>
    </div>
</div>
