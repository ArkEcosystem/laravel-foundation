@props([
    'document',
])

@if($document->hasPrevious() || $document->hasNext())
    <div class="flex justify-between py-8 mt-8 space-x-4 border-t border-theme-secondary-200">
        @if($document->hasPrevious())
            <a
                href="{{ $document->previous()->url() }}"
                class="flex-1 p-4 bg-white rounded-lg border-2 cursor-pointer hover:border-transparent hover:shadow-lg border-theme-primary-100 transition-default hover:size-increase"
            >
                <div class="flex justify-between items-center">
                    <span class="flex justify-center items-center w-14 h-14 rounded-xl button-secondary">
                        <x-ark-icon name="arrows.chevron-left" />
                    </span>

                    <div class="flex flex-col justify-center items-end">
                        <span class="text-sm font-semibold sm:hidden md:block text-theme-secondary-500">
                            @lang('ui::generic.previous')
                        </span>

                        <span class="hidden font-semibold text-right sm:block md:mt-2 text-theme-secondary-900">
                            {{ $document->previous()->name }}
                        </span>
                    </div>
                </div>
            </a>
        @endif

        @if($document->hasNext())
            <a href="{{ $document->next()->url() }}" class="flex-1 p-4 bg-white rounded-lg border-2 cursor-pointer hover:border-transparent hover:shadow-lg border-theme-primary-100 transition-default hover:size-increase">
                <div class="flex justify-between items-center">
                    <div class="flex flex-col justify-center items-start">
                        <span class="text-sm font-semibold sm:hidden md:block text-theme-secondary-500">
                            @lang('ui::generic.next')
                        </span>

                        <span class="hidden font-semibold sm:block md:mt-2 text-theme-secondary-900">
                            {{ $document->next()->name }}
                        </span>
                    </div>
                    <span class="flex justify-center items-center w-14 h-14 rounded-xl button-secondary">
                        <x-ark-icon name="arrows.chevron-right" />
                    </span>
                </div>
            </a>
        @endif
    </div>
@endif
