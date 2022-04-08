@props([
    'documentations',
    'title' => trans('ui::pages.docs.documentation_quick'),
])

<div class="bg-theme-secondary-100">
    <div class="flex flex-col items-center py-8 content-container">
        <h2 class="self-start header-2">
            {{ $title }}
        </h2>

        <x-ark-expandable :total="$documentations->count()" class="expandable-quick-access">
            @foreach($documentations as $documentation)
                <x-ark-expandable-item>
                    <a
                        href="{{ $documentation->isComingSoon() ? '#!' : $documentation->url() }}"
                        @class(['relative', 'coming-soon' => $documentation->isComingSoon()])
                        @if($documentation->isComingSoon())
                            data-tippy-content="Coming soon"
                        @endif
                    >
                        <span class="absolute top-3 right-3 py-px px-1 text-xs font-bold text-white rounded bg-theme-secondary-900">
                            {{ $documentation->ticker }}
                        </span>

                        <x-ark-icon
                            name="home-quick-access/{{ $documentation->logo }}"
                            class="quick-access {{ $documentation->isComingSoon() ? 'disabled' : '' }}"
                            size="2xl"
                        />

                        <p class="mt-4 text-center">
                            {{ $documentation->title }}
                        </p>
                    </a>
                </x-ark-expandable-item>
            @endforeach

            <x-slot name="collapsed">
                <span class="text-2xl font-bold counter-after">+</span>
                <span>@lang('actions.show_more')</span>
            </x-slot>

            {{-- <x-slot name="expanded">
                <x-ark-icon name="hide" size="md" />
                <span>@lang('actions.hide')</span>
            </x-slot> --}}
        </x-ark-expandable>
    </div>
</div>
