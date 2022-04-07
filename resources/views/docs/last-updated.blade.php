<div class="text-sm flex space-x-2 items-center text-theme-secondary-500 font-semibold {{ $class ?? '' }}">
    @svg('clock', 'h-4 w-4')
    <span>Last updated {{ \Carbon\Carbon::parse($time)->diffForHumans() }}</span>
</div>
