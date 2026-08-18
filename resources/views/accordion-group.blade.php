<div x-data="{ openPanel: null }">
    <dl>
        @for ($i = 0; $i < $slots; $i++)
            <div class="@if ($i > 0) mt-5 @endif rounded-xl border border-theme-secondary-200 p-6">
                <dt>
                    <button type="button"
                        class="flex w-full items-center justify-between text-left text-theme-primary-600 focus:outline-none"
                        :class="{ 'mb-5': openPanel === {{ $i }} }"
                        @click="openPanel = (openPanel === {{ $i }} ? null : {{ $i }})">
                        <span class="text-lg font-semibold">
                            {{ ${"title_{$i}"} }}
                        </span>
                        <span class="ml-6 flex h-7 items-center">
                            <x-ark-chevron-toggle is-open="openPanel === {{ $i }}" class="transform" />
                        </span>
                    </button>
                </dt>
                <dd class="mt-2" x-show="openPanel === {{ $i }}" x-transition.opacity x-cloak>
                    {{ ${"slot_{$i}"} }}
                </dd>
            </div>
        @endfor
    </dl>
</div>
