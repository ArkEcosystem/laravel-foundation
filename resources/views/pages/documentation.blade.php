@props([
    'index',
    'document',
    'content',
    'banner' => null,
    'isTutorial' => false,
    'compact' => false,
    'editOption' => true,
])

<x-ark-container :container-class="Arr::toCssClasses(['flex-col pb-8', 'pt-8 md:pt-8' => $compact, 'pt-10 md:pt-12' => !$compact])">
    <div @class([
        'flex lg:divide-x divide-theme-secondary-200',
        'pb-8' => $compact,
        'py-8' => !$compact,
    ])>
        <aside class="hidden flex-shrink-0 lg:block">
            <div class="h-sidebar custom-scroll sticky top-32 w-72 overflow-y-auto pr-10">
                @if ($document->category)
                    <div class="pb-6 pl-6">
                        @unless ($isTutorial)
                            <div class="flex items-center space-x-3 text-theme-secondary-900">
                                <x-ark-icon name="navbar-{{ $document->category }}" size="lg" />

                                <span class="text-lg font-bold">
                                    @lang('menus.documentation.' . $document->category)
                                </span>
                            </div>
                        @else
                            <span class="text-sm font-semibold uppercase text-theme-secondary-500">
                                {{ Str::title(str_replace('-', ' ', $document->category)) }}
                            </span>
                        @endunless
                    </div>

                    <div class="ml-6 flex">
                        <x-ark-divider />
                    </div>
                @endif

                @include ($index)
            </div>
        </aside>

        <main class="w-full lg:w-auto lg:min-w-0 lg:flex-1 lg:pl-10">
            <div class="mobile-menu relative mb-8 h-14 w-full lg:hidden">
                <x-ark-secondary-menu :title="trans('ui::menus.menu')" navigation-class="overflow-y-auto max-h-88">
                    <x-slot name="navigation">
                        @include($index)
                    </x-slot>
                </x-ark-secondary-menu>
            </div>

            {{ $banner }}

            <div class="documentation-content break-words">
                @include($content)
            </div>

            {{-- Navigation --}}
            <x-ark-docs-navigation :document="$document" />

            {{-- Sharing --}}
            <div
                class="flex flex-col items-center justify-between space-y-5 border-t border-theme-secondary-200 pt-8 sm:flex-row-reverse sm:space-y-0">
                <div
                    class="flex flex-col items-center space-y-5 sm:flex-row sm:space-x-5 sm:space-y-0 sm:divide-x sm:divide-theme-secondary-200">
                    <x-ark-docs-last-updated :time="$document->updated_at" />

                    @if ($editOption)
                        <x-ark-docs-edit-page :document="$document" />
                    @endif
                </div>

                <x-ark-docs-share-links :document="$document" />
            </div>
        </main>
    </div>
</x-ark-container>
