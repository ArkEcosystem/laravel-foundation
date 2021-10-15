@auth
    @isset($navbarNotifications)
        {{ $navbarNotifications }}
    @endisset

    @isset($notifications)
        @include('ark::navbar.notifications', ['class' => $notificationsButtonClasses ?? '' ])
    @endisset

    <div @class(['ml-3' => isset($navbarNotifications) || isset($notifications)])>
        @isset($profile)
            {{ $profile }}
        @else
            @include('ark::navbar.profile')
        @endisset
    </div>
@else
    <div class="flex items-center sm:space-x-6">
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="hidden font-semibold sm:block link">@lang('actions.sign_up')</a>
        @endif

        @if(Route::has('login'))
            <a href="{{ route('login') }}" class="whitespace-nowrap button-secondary">@lang('actions.sign_in')</a>
        @endif
    </div>
@endauth
