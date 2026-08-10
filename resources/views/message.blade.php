<a href="{{ $message['url'] }}"
    class="flex flex-1 select-none border-b border-dotted px-6 py-6 last:border-b-0 hover:bg-theme-secondary-100">
    <div class="mr-4">
        <img src="{{ $message['image'] }}" class="w-12 rounded-full" />
    </div>

    <div class="flex w-5/6 flex-1 flex-col">
        <div class="flex">
            <div class="flex-1 font-semibold">
                {{ $message['name'] }}
            </div>

            <div class="w-32 text-right font-semibold text-theme-secondary-500">
                @if ($message['isYours'] && $message['isRead'])
                    <x-ark-icon name="double-check-mark" size="xs" class="mr-2 inline" />
                @elseif($message['isYours'])
                    <x-ark-icon name="check-mark-bold" size="xs" class="mr-2 inline" />
                @endif

                <span class="text-xs">{{ $message['date'] }}</span>
            </div>
        </div>

        <div class="truncate">
            {{ $message['content'] }}
        </div>
    </div>
</a>
