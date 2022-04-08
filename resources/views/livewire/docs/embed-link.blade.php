<div class="flex overflow-hidden flex-col bg-white rounded-xl border-2 cursor-pointer sm:flex-row hover:border-0 hover:shadow-lg embed-link border-theme-primary-100 transition-default hover:size-increase">
    <div class="flex flex-col flex-1 justify-between p-8">
        <div class="flex flex-col">
            <span class="pb-2 text-sm border-b border-dashed border-theme-primary-100">
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

    <div class="flex-shrink-0 w-full max-h-32 border-l-2 sm:w-1/4 sm:max-h-full border-theme-primary-100">
        <img class="object-cover w-full h-full" src="{{ $image }}" alt="{{ $title }}">
    </div>
</div>
