@props([
    'isArkProduct'  => true,
    'copyText'      => 'ARK.io | ' . trans('ui::general.all_rights_reserved'),
    'copyrightSlot' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-3 font-semibold text-sm text-theme-secondary-700 sm:space-y-0 sm:space-x-1 leading-6']) }}>
    <span>
        {{ date('Y') }} &copy; {{ $copyText }}
    </span>

    @if($isArkProduct || $copyrightSlot !== null)
        <span>
            @if($isArkProduct)
                <span>
                    <span class="hidden mr-1 sm:inline"> | </span>
                    <span>
                        <x-ark-icon
                            name="networks.ark-square"
                            class="inline-block mr-1 -mt-1 ark-logo-red"
                        />

                        An <a href="https://ark.io/" class="underline hover:no-underline focus-visible:rounded">ARK.io</a> @lang('ui::generic.product')
                    </span>
                </span>
            @endif

            {{ $copyrightSlot }}
        </span>
    @endif
</div>
