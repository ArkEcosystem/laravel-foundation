@props ([
    'path',
    'name',
    'children' => [],
    'topLevel' => false,
    'first' => false,
    'borderless' => false,
])

@php($onDocs = Request::onDocs($path))

@if ($topLevel)
    <div class="flex lg:ml-2">
        <div @class([
            'w-1 -mr-1 z-10',
            'bg-theme-primary-600 rounded-lg' => $onDocs,
        ])></div>

        <div @class([
            'rounded-r w-full pl-4 lg:pl-5',
            'text-theme-primary-600 bg-theme-primary-100' => $onDocs,
            'text-theme-secondary-900 hover:text-theme-primary-600' => ! $onDocs,
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
        <div class="flex relative pr-0 -mr-8 lg:mr-0 border-l border-theme-secondary-300">
            <div @class([
                'absolute h-full -left-2.5px z-10 border-l-4 rounded-lg',
                'border-theme-primary-600' => $onDocs,
                'border-transparent' => ! $onDocs,
            ])></div>

            <a
                href="{{ $path }}"
                @class([
                    'flex items-center block font-semibold pl-5 py-3 lg:rounded-r w-full text-sm',
                    'text-theme-primary-600 bg-theme-primary-100' => $onDocs,
                    'text-theme-secondary-900 hover:text-theme-primary-600' => ! $onDocs,
                ])
            >
                {{ $name }}
            </a>
        </div>
    @else
        <div class="flex pr-0 border-l -mr-8 lg:mr-0 border-theme-secondary-300">
            <div class="flex-1">
                <div class="flex justify-between items-center py-3 pl-5 space-x-3 w-full text-left">
                    <span class="text-sm font-semibold text-theme-secondary-700">
                        {{ $name }}
                    </span>
                </div>

                <div class="mt-1 ml-6 border-l border-theme-secondary-300">
                    @foreach ($children as $child)
                        <div class="relative">
                            @php($childOnDocs = Request::onDocs($child['path']))

                            @if ($childOnDocs)
                                <div @class([
                                    'absolute h-full -left-2.5px z-10 border-l-4 rounded-lg',
                                    'border-theme-primary-600' => $childOnDocs,
                                    'border-transparent' => ! $childOnDocs,
                                ])></div>
                            @endif

                            <a
                                href="{{ $child['path'] }}"
                                @class([
                                    'flex items-center text-xs font-semibold pl-4 py-3 lg:rounded-r w-full',
                                    'text-theme-primary-600 bg-theme-primary-100' => $childOnDocs,
                                    'text-theme-secondary-900 hover:text-theme-primary-600' => ! $childOnDocs,
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
