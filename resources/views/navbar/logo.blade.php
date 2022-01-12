<div class="flex flex-shrink-0 items-center">
    <a class="flex items-center rounded" href="{{ route('home') }}" dusk="navigation-logo-link">
        @isset($logo)
            {{ $logo }}
        @else
            <x-ark-icon name="networks.ark-square" size="xl" />
            <div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> {{ $title }}</div>
        @endisset
    </a>
</div>
