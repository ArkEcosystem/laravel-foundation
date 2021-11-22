@props([
    'title'       => null,
    'description' => null,
])

<div class="bg-theme-secondary-100">
    <div class="flex flex-col items-center text-center lg:space-x-16 contact-header">
        <h1 class="mb-0">{{ $title }}</h1>

        @if (strlen($description) > 0)
            <div class="mt-2 text-lg font-semibold">
                {{ $description }}
            </div>
        @endif
    </div>
</div>
