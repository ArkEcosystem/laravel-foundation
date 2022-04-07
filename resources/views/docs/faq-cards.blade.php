@if(count($entries))
    {{--
        Since Tailwindcss sets list-style="none",
        we need to explicitly add role="list" to bring back
        list functionality for screen readers.
    --}}
    <ul role="list" class="faq-entries grid gap-5 grid-cols-1 lg:grid-cols-3">
        @foreach($entries as $entry)
            <li>
                <x-ark-docs-card
                    id="faq-{{ $entry->faqId() }}"
                    :url="$entry->url()"
                    :title="$entry->faqTitle()"
                    :description="$entry->faqDescription()"
                />
            </li>
        @endforeach

        {{-- placeholders --}}
        @switch(count($entries))
            @case(1)
            @case(4)
                <li class="hidden lg:block"><x-ark-docs-card-placeholder /></li>
                <li class="hidden lg:block"><x-ark-docs-card-placeholder /></li>
                @break
            @case(2)
            @case(5)
                <li class="hidden lg:block"><x-ark-docs-card-placeholder /></li>
                @break
        @endswitch
    </ul>

    <a href="{{ $documentationLink }}" class="mt-8 w-full sm:w-auto button-secondary">
        @lang('ui::pages.docs.faq.full_documentation')
    </a>
@else
    <p class="p-6 w-full border border-theme-secondary-300 rounded-xl">
        @lang('ui::pages.docs.faq.no_results', [$category])
    </p>
@endif
