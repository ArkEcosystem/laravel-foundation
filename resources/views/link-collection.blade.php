@props([
    'links',
    'urlProperty' => 'path',
    'isExternal'  => false,
])

<div class="grid grid-cols-1 grid-flow-row gap-x-2 sm:grid-cols-2 lg:grid-cols-3 link-collection">
    @foreach ($links as $link)
        <div class="py-1">
            <a
                href="{{ $link[$urlProperty] }}"
                class="flex group no-underline pl-5 h-full w-full rounded transition-default border-2 border-theme-primary-100 hover:bg-theme-primary-700 hover:border-theme-primary-700"
                @if ($isExternal)
                    target="_blank"
                    rel="noopener nofollow noreferrer"
                @endif
            >
                <div class="flex flex-1 justify-between items-center text-theme-primary-600 group-hover:text-white">
                    <span class="py-2">{{ $link['name'] }}</span>

                    <div class="flex items-center justify-center bg-theme-primary-100 group-hover:bg-transparent w-11 h-full -my-px">
                        <x-ark-icon name="arrows.chevron-right" size="sm" />
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
