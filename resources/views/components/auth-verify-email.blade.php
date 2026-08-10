<div class="mx-auto my-6 flex max-w-xl rounded-lg bg-white p-8">
    <div class="flex w-full flex-col space-y-6 text-center">
        <div class="space-y-4">
            <h1>@lang('ui::auth.verify.page_header')</h1>

            <p>@lang('ui::auth.verify.link_description')</p>
        </div>

        <img class="mx-12 mb-5" src="/images/auth/verify-email.svg" alt="" />

        <form wire:click.prevent="resend" wire:poll>
            <p class="lg:no-wrap-span-children text-sm text-theme-secondary-600">
                <span>@lang('ui::auth.verify.line_1')</span>
                <span>@lang('ui::auth.verify.line_2')</span>

                @if ($this->rateLimitReached())
                    <span class="link" data-tippy-content="@lang('ui::messages.resend_email_verification_limit')">
                        @lang('ui::actions.resend_email_verification')
                    </span>
                @else
                    <button wire:loading.attr="disabled" type="submit" class="link">
                        @lang('ui::actions.resend_email_verification')
                    </button>
                @endif
            </p>
        </form>
    </div>
</div>
