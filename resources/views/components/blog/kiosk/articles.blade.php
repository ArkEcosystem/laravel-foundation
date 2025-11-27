<x-ark-container>
    <div class="flex justify-end items-center space-x-3">
        <div>
            <x-ark-input
                name="search"
                placeholder="Search..."
                input-class="-mt-2"
                hide-label
            />
        </div>

        <a href="{{ route('kiosk.users') }}" class="button-primary">
            Users
        </a>

        <a href="{{ route('kiosk.articles.create') }}" class="button-primary">
            New Article
        </a>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block py-2 min-w-full align-middle">
                <div class="overflow-hidden sm:rounded-lg">
                    @if ($this->articles->isEmpty())
                        <x-ark-no-results />
                    @else
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 pr-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Title
                                    </th>
                                    <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Date
                                    </th>
                                    <th scope="col" class="relative py-3 pl-6"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-theme-secondary-200">
                                @foreach($this->articles as $article)
                                    <tr>
                                        <td class="py-4 pr-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-10 h-10 rounded-full" src="{{ $article->author->photo() }}" alt="">
                                                </div>
                                                <div class="flex items-center ml-4 space-x-2">
                                                    <div class="font-medium text-gray-900">
                                                        <a href="{{ $article->url() }}">{{ $article->title }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($article->published_at)
                                                    {{ $article->published_at->toDayDateTimeString() }}
                                                @else
                                                    <span class="font-bold">DRAFT</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 pl-6 text-sm font-medium text-right whitespace-nowrap" x-data>
                                            <div class="flex justify-end items-center space-x-8">
                                                <a href="{{ route('kiosk.article', $article) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <button
                                                    type="button"
                                                    class="flex items-center space-x-1 text-sm font-medium text-theme-danger-600"
                                                    @click="$dispatch('triggerArticleDelete', {id: {{ $article->id }}})"
                                                >
                                                    <x-ark-icon name="trash" size="sm" />

                                                    <span>Remove</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center mt-6">
        {{ $this->articles->links("ark::pagination-url") }}
    </div>

    <livewire:kiosk-delete-article />
</x-ark-container>
