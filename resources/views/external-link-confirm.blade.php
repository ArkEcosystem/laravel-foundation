@props([
    'selector' => null,
])
{{-- External link svg uses the below classes so needs adding here so purge keeps them --}}
{{-- inline ml-1 -mt-1.5 --}}
<x-ark-js-modal class="md:mt-22 w-full text-left" width-class="md:max-w-xl" content-class="rounded"
    name="external-link-confirm" buttons-style="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3"
    x-data="{
        url: null,
        hasConfirmedLinkWarning: false,
        toggle() {
            this.hasConfirmedLinkWarning = !this.hasConfirmedLinkWarning;
        },
        onBeforeShow([url]) {
            this.url = url;
        },
        onHidden() {
            this.hasConfirmedLinkWarning = false;
            document.querySelector('input[name=confirmation]').checked = false;
        },
        followLink() {
            if (this.hasConfirmedLinkWarning) {
                localStorage.setItem('has_disabled_link_warning', true)
            }
    
            this.hide();
        },
        ...(typeof ExternalLinkConfirm !== 'undefined' ? ExternalLinkConfirm : {})
    }" disable-outside-click hide-cross square init>
    <x-slot name="title">
        @lang('ui::general.external_link')
    </x-slot>

    <x-slot name="description">
        <div class="mt-4 flex flex-col space-y-6 whitespace-normal">
            <div class="font-semibold text-theme-secondary-900">
                <x-ark-alert type="warning">
                    <span class="block break-words leading-6" x-text="url"></span>
                </x-ark-alert>
            </div>

            <p class="text-theme-secondary-700 dark:text-theme-secondary-500">@lang('ui::general.external_link_disclaimer')</p>

            <x-ark-checkbox name="confirmation" alpine="toggle"
                label-classes="text-theme-secondary-700 dark:text-theme-secondary-500 select-none font-semibold">
                @slot('label')
                    @lang('ui::forms.do_not_show_message_again')
                @endslot
            </x-ark-checkbox>
        </div>
    </x-slot>

    <x-slot name="backdrop">
        <x-modal.close-button click="hide" class="fixed right-0 top-0 z-20" />

        <div
            class="fixed inset-0 flex h-screen w-screen flex-col bg-white bg-opacity-90 backdrop-blur-xl backdrop-filter dark:bg-black dark:bg-opacity-95">
        </div>
    </x-slot>

    <x-slot name="buttons">
        <button class="button-secondary mt-3 sm:mt-0" @click="hide">
            @lang('ui::actions.back')
        </button>

        <a target="_blank" rel="noopener nofollow" class="button-primary cursor-pointer" :href="url"
            @click="followLink()" data-safe-external="true">
            @lang('ui::actions.follow_link')
        </a>
    </x-slot>
</x-ark-js-modal>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        function initExternalLinkConfirm() {
            const selectors = [
                '[href*="://"]',
                ':not([href^="{{ config('app.url') }}"])',
                ':not([data-safe-external])',
                ':not([data-external-link-confirm])',
            ];

            const links = document.querySelectorAll(
                @if ($selector)
                    `{{ $selector }} a${selectors.join('')}`
                @else
                    `a${selectors.join('')}`
                @endif
            );

            const hasDisabledLinkWarning = () => localStorage.getItem('has_disabled_link_warning') === 'true';

            links.forEach(function(link) {
                link.setAttribute('data-external-link-confirm', 'true');

                const clickHandler = (e) => {
                    if (hasDisabledLinkWarning()) {
                        return;
                    }

                    e.preventDefault();

                    e.stopPropagation();

                    Livewire.dispatch('openModal', 'external-link-confirm', link.getAttribute(
                        'href'));
                };

                link.addEventListener("auxclick", (event) => {
                    if (event.button === 1) {
                        clickHandler(event);
                    }
                });

                link.addEventListener('click', clickHandler, false);
            });
        }

        Livewire.hook("commit", ({
            succeed
        }) => {
            succeed(() => {
                initExternalLinkConfirm();
            });
        });

        initExternalLinkConfirm();
    });
</script>
