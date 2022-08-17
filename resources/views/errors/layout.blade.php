@component('layouts.app', ['verticalCenterContent' => true])
    @php
        $code = match ($code) {
            401 => 401,
            403 => 403,
            404 => 404,
            419 => 419,
            429 => 429,
            503 => 503,
            default => 500,
        };
    @endphp

    @if ($code ?? null)
        @section('title', trans('ui::errors.'.$code) . ' | '.config('app.name'))

        @section('image')
            <x-ark-icon
                :name="'app-errors.'.$code"
                class="light-dark-icon"
                size="w-full h-full"
            />
        @endsection
    @endif

    @section('buttons')
        <a
            class="button button-secondary"
            @if (view()->exists('contact'))
                href="mailto:{{ config('mail.contact_email') }}"
            @else
                href="{{ route('contact') }}"
            @endif
        >
            @lang('ui::actions.contact')
        </a>

        <a href="{{ route('home') }}" class="button button-primary">
            @lang('ui::general.home')
        </a>
    @endsection

    @section('content')
        <x-ark-container class="flex m-auto w-full md:items-center">
            <div class="text-center">
                <div class="mx-auto max-w-error-image">
                    @yield('image')
                </div>

                @if($maintenance ?? false)
                    <h1 class="px-2 mt-8 xl:px-0 header-2">
                        @lang('ui::errors.503_heading')
                    </h1>

                    <p class="px-8 mt-4 leading-loose dark:text-theme-secondary-500">
                        @lang('ui::errors.503_message')
                    </p>
                @else
                    <h1 class="mt-8 header-2">
                        @yield('heading', trans('ui::errors.heading'))
                    </h1>

                    <p class="mt-4 leading-loose dark:text-theme-secondary-500">
                        @yield('message', trans('ui::errors.message'))
                    </p>

                    <div class="flex flex-col mt-8 space-y-3 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-3">
                        @yield('buttons')
                    </div>
                @endif
            </div>
        </x-ark-container>
    @endsection
@endcomponent
