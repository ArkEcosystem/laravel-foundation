@if($document->hasPrevious() || $document->hasNext())
    <div class="flex justify-between space-x-4 border-t border-theme-secondary-200 py-8 mt-8">
        @if($document->hasPrevious())
            <a href="{{ $document->previous()->url() }}" class="flex-1 border-2 border-theme-primary-100 p-4 rounded-lg hover:border-transparent hover:size-increase hover:shadow-lg bg-white transition-default cursor-pointer">
                <div class="flex items-center justify-between">
                    <span class="button-secondary flex items-center justify-center rounded-xl h-14 w-14">@svg('chevron-left', 'h-5 w-5')</span>
                    <div class="flex flex-col justify-center items-end">
                        <span class="sm:hidden md:block text-sm font-semibold text-theme-secondary-500">Previous</span>
                        <span class="hidden sm:block md:mt-2 text-theme-secondary-900 font-semibold text-right">{{ $document->previous()->name }}</span>
                    </div>
                </div>
            </a>
        @endif
        @if($document->hasNext())
            <a href="{{ $document->next()->url() }}" class="flex-1 border-2 border-theme-primary-100 p-4 rounded-lg hover:border-transparent hover:size-increase hover:shadow-lg bg-white transition-default cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col justify-center items-start">
                        <span class="sm:hidden md:block text-sm font-semibold text-theme-secondary-500">Next</span>
                        <span class="hidden sm:block md:mt-2 text-theme-secondary-900 font-semibold">{{ $document->next()->name }}</span>
                    </div>
                    <span class="button-secondary flex items-center justify-center rounded-xl h-14 w-14">@svg('chevron-right', 'h-5 w-5')</span>
                </div>
            </a>
        @endif
    </div>
@endif
