<div class="embed-link flex flex-col sm:flex-row overflow-hidden rounded-xl border-2 border-theme-primary-100 bg-white transition-default hover:size-increase hover:shadow-lg hover:border-0 cursor-pointer">
    <div class="flex flex-col justify-between flex-1 p-8">
        <div class="flex flex-col">
            <span class="text-sm border-b border-dashed border-theme-primary-100 pb-2">
                <x-ark-external-link :url="$hostUrl" :text="$host" small />
            </span>
            <a href="{{ $url }}" target="_blank" rel="noopener nofollow noreferrer" class="block">
                <h3 class="mt-2 text-xl font-semibold text-theme-secondary-900">
                    {{ $title }}
                </h3>
                <div class="mt-3 text-theme-secondary-700">
                    {{ $description }}
                </div>
            </a>
        </div>
    </div>

    <div class="flex-shrink-0 border-l-2 border-theme-primary-100 w-full sm:w-1/4 max-h-32 sm:max-h-full">
        <img class="object-cover w-full h-full" src="{{ $image }}" alt="{{ $title }}">
    </div>
</div>
