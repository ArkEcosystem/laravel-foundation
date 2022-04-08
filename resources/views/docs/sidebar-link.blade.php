@if(! ($children ?? false))
    <div class="flex">
        <div class="@if(Request::onDocs($path)) bg-theme-primary-600 rounded-lg @endif w-2 -mr-1 z-10"></div>
        <a
            href="{{ $path }}"
            class="flex items-center block font-semibold pl-8 py-4 @if(Request::onDocs($path)) text-theme-primary-600 bg-theme-primary-100 @else text-theme-secondary-900 hover:text-theme-primary-600 @endif rounded-r w-full"
        >
            {{ $name }}
        </a>
    </div>
@else
    <div x-data="{ dropdownOpen: {{ Request::onChildPage($path) ? 'true' : 'false' }} }" >
        <div class="flex">
            <div :class="{ 'bg-theme-primary-600 rounded-lg': dropdownOpen }" class="w-2 -mr-1 z-10"></div>
            <button
                type="button"
                @click="dropdownOpen = !dropdownOpen"
                :class="{
                    'text-theme-primary-600 bg-theme-primary-100': dropdownOpen,
                    'text-theme-secondary-900 hover:text-theme-primary-600': !dropdownOpen
                }"
                class="flex space-x-3 items-center block font-semibold pl-8 pr-3 py-4 rounded-r w-full text-left"
            >
                <span>{{ $name }}</span>
                <span :class="{ 'rotate-90': dropdownOpen }" class="transition-default">@svg('chevron-right', 'h-3 w-3')</span>
            </button>
        </div>
        <div x-show="dropdownOpen" class="ml-8 border-l border-theme-primary-100 my-1" x-cloak>
            @foreach ($children as $child)
                <div class="flex">
                    <div class="@if(Request::onDocs($child['path'])) bg-theme-primary-600 rounded-lg @endif w-2 -mr-1 z-10"></div>
                    <a
                        href="{{ $child['path'] }}"
                        class="flex items-center block font-semibold pl-8 py-4 @if(Request::onDocs($child['path'])) text-theme-primary-600 bg-theme-primary-100 @else text-theme-secondary-900 hover:text-theme-primary-600 @endif rounded-r w-full"
                    >
                        {{ $child['name'] }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
