@auth
    @isset($navbarNotifications)
        {{ $navbarNotifications }}
    @endisset

    @isset($notifications)
        @include('ark::navbar.notifications', ['class' => $notificationsButtonClasses ?? ''])
    @endisset

    <div @class([
        'ml-3' => isset($navbarNotifications) || isset($notifications),
    ])>
        @isset($profile)
            {{ $profile }}
        @else
            @include('ark::navbar.profile')
        @endisset
    </div>
@else
    <div class="flex items-center sm:space-x-6">
        @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="transition-default hidden font-semibold text-theme-primary-600 hover:text-theme-primary-700 dark:text-theme-secondary-200 dark:hover:text-theme-primary-700 sm:block">@lang('actions.sign_up')</a>
        @endif

        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="button-secondary whitespace-nowrap">@lang('actions.sign_in')</a>
        @endif
    </div>
@endauth
