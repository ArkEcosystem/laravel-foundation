@props([
    'index',
    'document',
    'content',
    'banner'     => null,
    'isTutorial' => false,
    'compact'    => false,
])

<x-ark-container container-class="flex-col pb-8 {{ $compact ? 'pt-8 md:pt-8' : 'pt-10 md:pt-12' }}">
    <div class="flex {{ $compact ? 'pb-8' : 'py-8' }} lg:divide-x divide-theme-secondary-200">
        <aside class="hidden flex-shrink-0 lg:block w-68">
            <div class="overflow-y-auto sticky top-32 pr-10 h-sidebar custom-scroll">
                @if($document->category)
                    <div @class([
                        'flex items-center  space-x-3 text-theme-secondary-900',
                        'ml-9 mb-8' => ! $isTutorial,
                        'ml-7' => $isTutorial,
                    ])>
                        @unless ($isTutorial)
                            <x-ark-icon
                                name="navbar-{{ $document->category }}"
                                size="lg"
                            />

                            <span class="text-lg font-bold">
                                @lang('menus.documentation.'.$document->category)
                            </span>
                        @else
                            <div class="flex-1">
                                <span class="text-sm font-semibold uppercase text-theme-secondary-500">
                                    {{ Str::title(str_replace('-', ' ', $document->category)) }}
                                </span>

                                <div class="flex mt-6">
                                    <x-ark-divider />
                                </div>
                            </div>
                        @endunless
                    </div>
                @endif

                @include ($index)
            </div>
        </aside>

        <main class="w-full lg:pl-10 lg:w-3/4">
            <div class="relative mb-8 w-full h-14 lg:hidden mobile-menu">
                <x-ark-secondary-menu
                    :title="trans('ui::menus.menu')"
                    navigation-class="overflow-y-auto max-h-88"
                >
                    <x-slot name="navigation">
                        @include($index)
                    </x-slot>
                </x-ark-secondary-menu>
            </div>

            {{ $banner }}

            <div class="break-words documentation-content">
                @include($content)
            </div>

            {{-- Navigation --}}
            <x-ark-docs-navigation :document="$document" />

            {{-- Sharing --}}
            <div class="flex flex-col justify-between items-center pt-8 space-y-5 border-t sm:flex-row-reverse sm:space-y-0 border-theme-secondary-200">
                <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0 sm:space-x-5 sm:divide-x sm:divide-theme-secondary-200">
                    <x-ark-docs-last-updated :time="$document->updated_at" />

                    <x-ark-docs-edit-page :document="$document" />
                </div>

                <x-ark-docs-share-links :document="$document" />
            </div>
        </main>
    </div>
</x-ark-container>
