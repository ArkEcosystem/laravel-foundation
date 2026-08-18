@props(['document'])

@if ($document->hasPrevious() || $document->hasNext())
    <div class="mt-8 flex justify-between space-x-4 border-t border-theme-secondary-200 py-8">
        @if ($document->hasPrevious())
            <a href="{{ $document->previous()->url() }}"
                class="transition-default hover:size-increase flex-1 cursor-pointer rounded-lg border-2 border-theme-primary-100 bg-white p-4 hover:border-transparent hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <span class="button-secondary flex h-14 w-14 items-center justify-center rounded-xl">
                        <x-ark-icon name="arrows.chevron-left" />
                    </span>

                    <div class="flex flex-col items-end justify-center">
                        <span class="text-sm font-semibold text-theme-secondary-500 sm:hidden md:block">
                            @lang('ui::generic.previous')
                        </span>

                        <span class="hidden text-right font-semibold text-theme-secondary-900 sm:block md:mt-2">
                            {{ $document->previous()->name }}
                        </span>
                    </div>
                </div>
            </a>
        @endif

        @if ($document->hasNext())
            <a href="{{ $document->next()->url() }}"
                class="transition-default hover:size-increase flex-1 cursor-pointer rounded-lg border-2 border-theme-primary-100 bg-white p-4 hover:border-transparent hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col items-start justify-center">
                        <span class="text-sm font-semibold text-theme-secondary-500 sm:hidden md:block">
                            @lang('ui::generic.next')
                        </span>

                        <span class="hidden font-semibold text-theme-secondary-900 sm:block md:mt-2">
                            {{ $document->next()->name }}
                        </span>
                    </div>
                    <span class="button-secondary flex h-14 w-14 items-center justify-center rounded-xl">
                        <x-ark-icon name="arrows.chevron-right" />
                    </span>
                </div>
            </a>
        @endif
    </div>
@endif
