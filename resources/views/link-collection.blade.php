@props(['links', 'urlProperty' => 'path', 'isExternal' => false])

<div class="link-collection grid grid-flow-row grid-cols-1 gap-x-2 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($links as $link)
        <div class="py-1">
            <a href="{{ $link[$urlProperty] }}"
                class="transition-default group flex h-full w-full rounded border-2 border-theme-primary-100 pl-3 no-underline hover:border-theme-primary-700 hover:bg-theme-primary-700"
                @if ($isExternal) target="_blank"
                    rel="noopener nofollow noreferrer" @endif>
                <div class="flex flex-1 items-center justify-between text-theme-primary-600 group-hover:text-white">
                    <span class="py-2 pr-3">{{ $link['name'] }}</span>

                    <div
                        class="transition-default -my-px flex h-full w-8 items-center justify-center bg-theme-primary-100 group-hover:bg-transparent">
                        <x-ark-icon name="arrows.chevron-right" size="sm" />
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
