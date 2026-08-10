@if ($title || $hasViewAll)
    <div @class([
        $headerClass,
        'sm:justify-between' => $title,
        'sm:justify-end' => !$title,
    ])>
        @if ($title)
            <div class="slider-title {{ $titleClass }}">
                {{ $title }}

                @if ($titleTooltip)
                    <div class="inline-flex items-end">
                        <x-ark-info :tooltip="$titleTooltip" class="absolute -top-10 ml-1" type="hint" large />
                    </div>
                @endif
            </div>
        @endif

        <div class="relative flex items-center justify-between space-x-6">
            @if ($topPagination)
                <div class="swiper-pagination {{ $paginationClass }} text-right"></div>
            @endif

            @if ($hasViewAll)
                <div class="flex-shrink-0 leading-5">
                    <a href="{{ $viewAllUrl }}" class="link font-semibold">
                        @lang('ui::actions.view_all')

                        <x-ark-icon class="inline-block" name="arrows.chevron-right" size="2xs" />
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
