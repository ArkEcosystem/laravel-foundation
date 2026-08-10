<div class="description-block">
    <div class="flex justify-center">
        <img @unless ($lazyLoad ?? false)
                src="{{ $image }}"
            @else
                lazy="{{ $image }}"
            @endif
            class="max-w-full" />
    </div>

    <div class="mt-8 flex flex-col space-y-4">
        <span class="text-xl font-bold text-theme-secondary-900">
            {{ $title }}
        </span>

        <span class="paragraph-description">{{ $description }}</span>
    </div>
</div>
