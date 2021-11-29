@props([
    'isArkProduct'  => true,
    'copyText'      => 'ARK.io | ' . trans('ui::general.all_rights_reserved'),
    'copyrightSlot' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col pt-5 pb-4 space-y-2 font-semibold text-sm text-theme-secondary-700 sm:flex-row sm:space-y-0 sm:space-x-1']) }}>
    <span class="break-words">
        {{ date('Y') }} &copy; {{ $copyText }}

    @if($isArkProduct || $copyrightSlot !== null)
        @if($isArkProduct)
            <span class="hidden mr-1 sm:inline"> | </span>
            <span class="mr-1 whitespace-nowrap">
                <x-ark-icon
                    name="ark-logo-red-square"
                    class="inline-block mr-1 -mt-1"
                />

                <span class="hidden sm:inline">@lang('ui::generic.an')</span>
                <a href="https://ark.io/" class="underline hover:no-underline focus-visible:rounded">ARK.io</a>
                @lang('ui::generic.product')
                <span class="sm:hidden">|</span>
            </span>
        @endif

        {{ $copyrightSlot }}
    @endif
    </span>
</div>