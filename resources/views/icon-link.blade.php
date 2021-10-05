<a href="{{ $href }}" target="{{ $target ?? '_self' }}" rel="{{ $rel ?? ''}}" class="flex items-center space-x-2 font-semibold link">
    @if(! ($hideIcon ?? false))<span><x-ark-icon name="link" /></span>@endif
    <span>{{ $slot }}</span>
</a>
