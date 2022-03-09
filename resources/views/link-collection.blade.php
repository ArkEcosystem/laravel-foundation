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
                class="flex pl-5 w-full h-full no-underline rounded border-2 group transition-default border-theme-primary-100 hover:bg-theme-primary-700 hover:border-theme-primary-700"
                @if ($isExternal)
                    target="_blank"
                    rel="noopener nofollow noreferrer"
                @endif
            >
                <div class="flex flex-1 justify-between items-center group-hover:text-white text-theme-primary-600">
                    <span class="py-2">{{ $link['name'] }}</span>

                    <div class="flex justify-center items-center -my-px w-11 h-full group-hover:bg-transparent bg-theme-primary-100">
                        <x-ark-icon name="arrows.chevron-right" size="sm" />
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
