@props([
    'title',
    'slot',
    'dark'            => false,
    'border'          => true,
    'leftBorder'      => false,
    'containerClass'  => '',
    'titleClass'      => 'text-lg font-semibold',
    'iconClass'       => 'text-theme-secondary-700',
    'iconSize'        => 'xs',
    'toggleTitle'     => false,
    'iconOpenClass'   => 'rotate-180',
    'iconClosedClass' => '',
    'contentClass'    => '',
    'buttonClass'     => 'px-4 py-6',
    'buttonOpenClass' => '',
    'onToggle'        => null,
])

<div
    {{ $attributes->class('accordion group') }}
    x-data="{
        openPanel: false,
        toggle: function () {
            this.openPanel = ! this.openPanel;
            @if($onToggle)
                ({{ $onToggle }}).call(this);
            @endif
        },
    }"
    :class="{ 'accordion-open': openPanel }"
>
    <dl>
        <div @class([
            $containerClass,
            'border-t border-theme-secondary-300 md:border-2 md:border-theme-secondary-200 md:rounded-xl' => $dark === false && $border,
        ])>
            <dt>
                <button
                    @click="toggle"
                    @class([
                        'accordion-trigger',
                        $buttonClass,
                        'text-theme-secondary-400' => $dark,
                        'text-theme-secondary-900' => ! $dark,
                    ])
                    @if($buttonOpenClass)
                        :class="{ '{{ $buttonOpenClass }}': openPanel }"
                    @endif
                >
                    <div class="{{ $titleClass }}">
                        @if($toggleTitle)
                            <span x-show="openPanel" x-cloak>
                                @lang('ui::actions.hide') {{ $title }}
                            </span>

                            <span x-show="!openPanel">
                                @lang('ui::actions.show') {{ $title }}
                            </span>
                        @else
                            <span>{{ $title }}</span>
                        @endif
                    </div>

                    <div class="flex items-center justify-center h-8 w-8 rounded-lg border-2 border-theme-primary-100 group-hover:border-theme-primary-400 transition-default">
                        <span
                            :class="{
                                '{{ $iconOpenClass }}': openPanel,
                                '{{ $iconClosedClass }}': !openPanel
                            }"
                            @class([
                                'transition duration-150 ease-in-out transform',
                                $iconClass,
                            ])
                        >
                            <x-ark-icon name="arrows.chevron-down-small" :size="$iconSize" />
                        </span>
                    </div>
                </button>
            </dt>

            <dd
                @class([
                    $contentClass,
                    'border-theme-secondary-800' => $dark,
                    'border-theme-secondary-300' => ! $dark,
                    'border-l' => $dark || $leftBorder,
                ])
                x-show="openPanel"
                x-transition.opacity
                x-cloak
            >
                {{ $slot }}
            </dd>
        </div>
    </dl>
</div>
