<section {{ $attributes->class('bg-theme-secondary-900') }}>
    <div class="flex flex-col py-12 px-8 mx-auto lg:flex-row lg:space-y-0 lg:space-x-6 lg:max-w-7xl lg:divide-x divide-theme-secondary-800">
        <div class="flex-1">
            <div class="space-y-4">
                <h3 class="text-theme-secondary-200">@lang('ui::pages.extended-footer.help.title')</h3>

                <div>@lang('ui::pages.extended-footer.help.description')</div>
            </div>


            <x-ark-divider class="my-6" color-class="bg-theme-secondary-800" />

            <x-footer.socials class="hidden lg:block" />
        </div>

        {{-- <livewire:footer-contact /> --}}

        <x-ark-divider class="my-6 lg:hidden" color-class="bg-theme-secondary-800" />

        <x-footer.socials class="lg:hidden" />
    </div>
</section>
