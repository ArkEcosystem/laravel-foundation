@props ([
    'path',
    'name',
    'children' => [],
    'topLevel' => false,
    'first' => false,
    'borderless' => false,
])

@if ($topLevel)
    <div class="flex -mb-4 lg:ml-2">
        <div @class([
            'w-2 -mr-1 z-10',
            'bg-theme-primary-600 rounded-lg' => Request::onDocs($path),
        ])></div>

        <div @class([
            'rounded-r w-full pl-4 lg:pl-5',
            'text-theme-primary-600 bg-theme-primary-100' => Request::onDocs($path),
            'text-theme-secondary-900 hover:text-theme-primary-600' => ! Request::onDocs($path),
        ])>
            <a
                href="{{ $path }}"
                @class([
                    'border-theme-secondary-300 py-4 flex items-center block font-semibold w-full',
                    $first ? 'lg:border-t' : 'border-t' => ! $borderless,
                ])
            >
                {{ $name }}
            </a>
        </div>
    </div>
@else
    @if (count($children) === 0)
        <div class="flex pr-5 pl-5 lg:pr-0 lg:pl-0">
            <div @class([
                'w-2 -mr-1 z-10',
                'bg-theme-primary-600 rounded-lg' => Request::onDocs($path),
                'border-l border-theme-secondary-300' => ! Request::onDocs($path),
            ])></div>
            <a
                href="{{ $path }}"
                @class([
                    'flex items-center block font-semibold pl-5 py-3 rounded-r w-full text-sm',
                    'text-theme-primary-600 bg-theme-primary-100' => Request::onDocs($path),
                    'text-theme-secondary-900 hover:text-theme-primary-600' => ! Request::onDocs($path),
                ])
            >
                {{ $name }}
            </a>
        </div>
    @else
        <div class="flex pr-4 pl-5 lg:pr-0 lg:pl-0">
            <div class="z-10 -mr-1 w-2 border-l border-theme-secondary-300"></div>

            <div class="flex-1">
                <div class="flex justify-between items-center py-3 pr-2 pl-5 space-x-3 w-full text-left lg:pr-5">
                    <span class="text-sm font-semibold text-theme-secondary-700">
                        {{ $name }}
                    </span>

                    <span class="transition-default">
                        <x-ark-icon
                            name="arrows.chevron-up-small"
                            class="text-theme-secondary-500"
                            size="xs"
                        />
                    </span>
                </div>

                <div class="my-1 ml-6">
                    @foreach ($children as $child)
                        <div class="flex">
                            @if (Request::onDocs($child['path']))
                                <div @class([
                                    'w-2 -mr-1 z-10',
                                    'bg-theme-primary-600 rounded-lg' => Request::onDocs($child['path']),
                                ])></div>
                            @else
                                <div class="z-10 -mr-1 w-2 border-l border-theme-secondary-300"></div>
                            @endif

                            <a
                                href="{{ $child['path'] }}"
                                @class([
                                    'flex items-center text-xs font-semibold pl-5 py-3 rounded-r w-full',
                                    'text-theme-primary-600 bg-theme-primary-100' => Request::onDocs($child['path']),
                                    'text-theme-secondary-900 hover:text-theme-primary-600' => ! Request::onDocs($child['path']),
                                ])
                            >
                                {{ $child['name'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
