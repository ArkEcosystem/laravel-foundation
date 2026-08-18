<div class="w-full bg-theme-secondary-100 py-8 dark:bg-black">
    <div class="container mx-auto">
        <h1 class="mx-4 text-center dark:text-theme-secondary-200 md:mx-8 xl:mx-16">{{ $title ?? $pageTitle }}</h1>

        @isset($description)
            <p
                class="mx-8 mt-4 text-center text-lg font-semibold leading-8 text-theme-secondary-700 dark:text-theme-secondary-500 md:mx-8 xl:mx-16">
                {{ $description }}</p>
        @endisset
    </div>
</div>
