<div>
    <div class="flex flex-col items-center py-8 content-container">
        <h2 class="self-start header-2">{{ $title }}</h2>

        <div class="grid grid-cols-1 gap-5 mt-6 w-full sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($documentations as $documentation)
                <x-ark-docs-documentation-card
                    url="{{ $documentation->url() }}"
                    text="{{ $documentation->title }}"
                    icon="{{ $documentation->logo }}"
                    disabled="{{ $documentation->is_coming_soon }}"
                />
            @endforeach
        </div>
    </div>
</div>
