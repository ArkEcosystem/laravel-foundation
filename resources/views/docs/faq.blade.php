@props([
    'faq',
    'title' => trans('pages.docs.faq.title'),
])

<div>
    <div class="relative flex flex-col items-center w-full py-8 content-container">
        <h2 class="md:absolute top-11 self-start header-2">
            {{ $title }}
        </h2>

        <x-ark-tabbed
            default-selected="wallet"
            x-data="{ menuToggle: false, closeMenu() {() => menuToggle = false} }"
        >
            <x-slot name="tabsTrigger">

                {{--mobile--}}
                <div class="mt-3 relative md:hidden w-full">
                    <x-ark-dropdown
                        :init-alpine="false"
                        dropdown-property="menuToggle"
                        dropdown-classes="left-0 w-full z-20"
                        button-class="p-3 w-full font-semibold text-left text-theme-secondary-900 dark:text-theme-secondary-200"
                        wrapper-class="relative p-2 w-full rounded-xl border border-theme-primary-100 dark:border-theme-secondary-800"
                    >
                        <x-slot name="button">
                            <div class="flex items-center space-x-4">
                                <div wire:ignore>
                                    <div x-show="menuToggle !== true">
                                        <x-ark-icon name="menu" size="sm" />
                                    </div>

                                    <div x-show="menuToggle === true">
                                        <x-ark-icon name="menu-show" size="sm" />
                                    </div>
                                </div>

                                <span x-show="selected === 'wallet'">@lang('ui::pages.docs.faq.wallet')</span>
                                <span x-show="selected === 'sdk'">@lang('ui::pages.docs.faq.sdk')</span>
                            </div>
                        </x-slot>

                        <div class="block items-center py-3 mt-1">
                            <button
                                type="button"
                                wire:key="wallet"
                                @click="selected = 'wallet'; closeMenu()"
                                class="dropdown-entry"
                                :class="{ 'dropdown-entry-selected' : selected === 'wallet' }"
                            >
                                @lang('ui::pages.docs.faq.wallet')
                            </button>
                            <button
                                type="button"
                                wire:key="sdk"
                                @click="selected = 'sdk'; closeMenu()"
                                class="dropdown-entry"
                                :class="{ 'dropdown-entry-selected' : selected === 'sdk' }"
                            >
                                @lang('ui::pages.docs.faq.sdk')
                            </button>
                        </div>

                    </x-ark-dropdown>
                </div>

                {{--tablet/desktop--}}
                <div class="hidden md:block w-min-content self-start md:self-end">
                    <ul role="tablist" class="tabs">
                        <x-ark-tab selected-class="focus-visible:rounded" name="wallet">
                            @lang('ui::pages.docs.faq.wallet')
                        </x-ark-tab>
                        <x-ark-tab selected-class="focus-visible:rounded" name="sdk">
                            @lang('ui::pages.docs.faq.sdk')
                        </x-ark-tab>
                    </ul>
                </div>
            </x-slot>

            <x-ark-tab-panel name="wallet" class="flex flex-col items-center">
                <x-ark-docs-faq-cards
                    category="Wallet"
                    :entries="$faq['wallet']"
                    documentationLink="{{ route('documentation', 'wallet') }}"
                />
            </x-ark-tab-panel>

            <x-ark-tab-panel name="sdk" class="flex flex-col items-center">
                <x-ark-docs-faq-cards
                    category="SDK"
                    :entries="$faq['sdk']"
                    documentationLink="{{ route('documentation', 'sdk') }}"
                />
            </x-ark-tab-panel>
        </x-ark-tabbed>
    </div>
</div>
