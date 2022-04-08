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
                        <span class="absolute top-3 right-3 py-px px-1 font-bold text-xs rounded text-white bg-theme-secondary-900">
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
                <span class="counter-after font-bold text-2xl">+</span>
                <span>@lang('ui::actions.docs.show_more')</span>
            </x-slot>

            <x-slot name="expanded">
                <x-ark-icon name="eye-slash" size="md" />
                <span>@lang('ui::actions.docs.hide')</span>
            </x-slot>
        </x-ark-expandable>
    </div>
</div>
