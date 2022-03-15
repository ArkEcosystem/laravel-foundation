@props([
    'title',
    'slot',
    'dark'            => false,
    'border'          => false,
    'leftBorder'      => true,
    'containerClass'  => '',
    'titleClass'      => 'font-semibold',
    'iconSize'        => 'xs',
    'iconClass'       => 'group-hover:text-theme-primary-600',
    'toggleTitle'     => false,
    'iconOpenClass'   => 'rotate-180 text-theme-primary-500',
    'iconClosedClass' => 'text-theme-secondary-900',
    'contentClass'    => 'mb-4 ml-10',
    'buttonClass'     => 'py-4 px-10 group hover:bg-theme-secondary-100',
    'buttonOpenClass' => '',
    'onToggle'        => null,
])

<div
    class="accordion"
    x-data="{
        openPanel: false,
        toggle: function () {
            this.openPanel = ! this.openPanel;

            @if($onToggle === null)
                (() => {
                    const container = this.$root.closest('.dropdown-container')

                    for (const accordion of container.querySelectorAll('.accordion-open')) {
                        if (accordion === this.$root) {
                            continue;
                        }

                        accordion.querySelector('.accordion-trigger').click();
                    }

                    this.$nextTick(() => {
                        window.dispatchEvent(new CustomEvent('dropdown-update'));
                    });
                }).call(this);
            @elseif($onToggle)
                ({{ $onToggle }}).call(this);
            @endif
        },
    }"
    :class="{ 'accordion-open': openPanel }"
>
    <dl>
        <div @class([
            $containerClass,
            'border-2 border-theme-secondary-200 rounded-xl' => $dark === false && $border,
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

                    <span class="flex items-center h-7">
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
                    </span>
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
