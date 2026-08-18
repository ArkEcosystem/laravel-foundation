@props([
    'backgroundColor' => 'bg-theme-secondary-900',
])

<section {{ $attributes->class($backgroundColor) }}>
    <div
        class="mx-auto flex flex-col divide-theme-secondary-800 px-8 py-12 md:px-10 lg:max-w-7xl lg:flex-row lg:space-x-6 lg:space-y-0 lg:divide-x">
        <div class="flex-1">
            <div class="space-y-4">
                <h3 class="text-theme-secondary-200">@lang ('pages.extended-footer.help.title')</h3>
                <p>@lang ('pages.extended-footer.help.description')</p>
            </div>

            <x-ark-divider class="my-6" color-class="bg-theme-secondary-800" />

            @include ('ark::includes.footer.socials', [
                'class' => 'hidden lg:block',
                'slot' => $slot,
            ])
        </div>

        <livewire:footer-contact-form />

        <x-ark-divider class="my-6 lg:hidden" color-class="bg-theme-secondary-800" />

        @include ('ark::includes.footer.socials', [
            'class' => 'lg:hidden',
            'slot' => $slot,
        ])
    </div>
</section>
